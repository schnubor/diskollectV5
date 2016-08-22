<?php

namespace App\Http\Controllers;

use App\Vinyl;
use App\Track;
use App\Video;
use App\User;
use Discogs;
use GuzzleHttp;
use App\Http\Requests\DiscogsOAuthRequest;
use App\Http\Requests\DiscogsSearchRequest;
use App\Http\Requests\StoreVinylRequest;
use App\Http\Requests\EditVinylRequest;
use Illuminate\Http\Request;
use Auth;
use Session;

class VinylsController extends Controller
{
    /**
     * Authorize with Discogs.
     *
     * @return Response
     */
    public function oAuthDiscogs(DiscogsOAuthRequest $request)
    {
        // oAuth to Discogs to enable search
    $userAgent = 'Diskollect/1.0, +http://diskollect.com';  // specify recognizable user-agent

    $server = new \League\OAuth1\Client\Server\Discogs([
      'identifier' => env('DC_CONSUMER_KEY'),
      'secret' => env('DC_CONSUMER_SECRET'),
      'callback_uri' => 'http://'.$_SERVER['HTTP_HOST'].dirname(strtok($_SERVER['REQUEST_URI'], '?')).'/discogs',
    ], null, $userAgent);

    // no temporary token? redirect then
    if (!isset($_GET['oauth_token'])) {
        $tempCredentials = $server->getTemporaryCredentials();
        Session::put('tempCredentials', serialize($tempCredentials));
        Session::save();
        header('Location: '.$server->getAuthorizationUrl($tempCredentials));
        $server->authorize($tempCredentials);
        die(); // doesn't work without exiting the current script
    }

    // ok got temporary token
    // nb: you may save it in db
    $token = $server->getTokenCredentials(
      unserialize(Session::get('tempCredentials')),
      $request->input('oauth_token'),
      $request->input('oauth_verifier')
    );

    // Discogs TEST
    $client = Discogs\ClientFactory::factory([]);

        $oauth = new GuzzleHttp\Subscriber\Oauth\Oauth1([
      'consumer_key' => env('DC_CONSUMER_KEY'), // from Discogs developer page
      'consumer_secret' => env('DC_CONSUMER_SECRET'), // from Discogs developer page
      'token' => $token->getIdentifier(), // get this using a OAuth library
      'token_secret' => $token->getSecret(), // get this using a OAuth library
    ]);
        $client->getHttpClient()->getEmitter()->attach($oauth);
        $identity = $client->getOAuthIdentity();

        $user = Auth::user(); // Current user
        $user->discogs_access_token = $token->getIdentifier();
        $user->discogs_access_token_secret = $token->getSecret();
        $user->discogs_uri = $identity['resource_url'];
        $user->discogs_username = $identity['username'];

        if ($user->save()) {
            flash()->success('Success! You are now authenticated with Discogs.');

            return redirect()->route('get.search');
        } else {
            flash()->error('Oops! Something went wrong while saving your information. Please try again.');

            return redirect()->route('get.search');
        }

        flash()->error('Oops! There was an error handling the request from Discogs. Please try again.');

        return redirect()->route('get.search');
    }

    /**
     * Show the form to search discogs.
     *
     * @return Response
     */
    public function search()
    {
        $user = Auth::user();

        return view('vinyl.search')
            ->with('user', $user);
    }

    /**
     * Receive search results.
     *
     * @return Response
     */
    public function result(DiscogsSearchRequest $request)
    {
        $user = Auth::user();
        $artist = $request->input('artist');
        $title = $request->input('title');
        $catno = $request->input('catno');

        $client = Discogs\ClientFactory::factory([
        'defaults' => [
           'headers' => ['User-Agent' => 'Diskollect/0.1 +https://www.diskollect.com'],
        ],
        ]);
        $client->getHttpClient()->getEmitter()->attach(new Discogs\Subscriber\ThrottleSubscriber());

        $oauth = new GuzzleHttp\Subscriber\Oauth\Oauth1([
          'consumer_key' => env('DC_CONSUMER_KEY'), // from Discogs developer page
          'consumer_secret' => env('DC_CONSUMER_SECRET'), // from Discogs developer page
          'token' => $user->discogs_access_token, // get this using a OAuth library
          'token_secret' => $user->discogs_access_token_secret, // get this using a OAuth library
        ]);
        $client->getHttpClient()->getEmitter()->attach($oauth);

        $response = $client->search([
          'artist' => $artist,
          'title' => $title,
          'catno' => $catno,
          'format' => 'vinyl',
          'type' => 'release',
        ]);

        $results = [];

        // check if discogs tokens are valid
        $identity = $client->getOAuthIdentity();

        foreach ($response['results'] as $result) {
            if ($result['type'] == 'release') { // Release
                $release = $client->getRelease(['id' => $result['id'], 'curr_abbr' => $user->currency]);
                $release['type'] = 'release';
                array_push($results, $release);
            } else { // Master
                $master = $client->getMaster(['id' => $result['id']]);
                $master['type'] = 'master';
                array_push($results, $master);
            }
        }

        return $results;
    }

  /**
   * Import vinyls from Discogs.
   *
   * @return Response
   */
  public function import()
  {
      $user = Auth::user();

      return view('vinyl.import');
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();

        return view('vinyl.create')
      ->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreVinylRequest $request)
    {
        $user = Auth::user();
        $cover = '/images/PH_vinyl.svg';  // default cover

        // uploaded vinyl cover or URL
        if ($request->hasFile('coverFile')) {
            $path = public_path().'/images/vinyls';
            $file = $request->file('coverFile');
            $filename = 'vinyl_'.time().'_'.$file->getClientOriginalName();
            $file->move($path, $filename);
            $cover = '/images/vinyls/'.$filename;
        } elseif ($request->input('cover')) {
            $cover = $request->input('cover');
        }

        // Create vinyl
        $vinyl = Vinyl::create([
          'user_id' => $user->id,
          'artwork' => $cover,
          'artist' => $request->input('artist'),
          'title' => $request->input('title'),
          'label' => $request->input('label'),
          'genre' => $request->input('genre'),
          'price' => $request->input('price'),
          'country' => $request->input('country'),
          'size' => $request->input('size'),
          'count' => $request->input('count'),
          'color' => $request->input('color'),
          'type' => $request->input('type'),
          'releasedate' => $request->input('year'),
          'notes' => $request->input('notes'),
          'weight' => $request->input('weight'),
          'catno' => $request->input('catno'),
          'releasetype' => $request->input('format'),
          'release_id' => $request->input('release_id'),
          'discogs_uri' => $request->input('discogs_uri'),
          'spotify_id' => $request->input('spotify_id'),
        ]);

        if ($vinyl) {
            $tracklist = $request->input('tracklist');
            $videolist = $request->input('videos');

            // Tracklist
            if(isset($tracklist)){
                foreach ($tracklist as $track) {
                    Track::create([
                        'vinyl_id' => $vinyl->id,
                        'artist' => $vinyl->artist,
                        'title' => $track['title'],
                        'number' => $track['position'],
                        'duration' => $track['duration'],
                    ]);
                }
            }

            // Videos
            if(isset($videolist)){
                foreach ($videolist as $video) {
                    Video::create([
                        'vinyl_id' => $vinyl->id,
                        'title' => $video['title'],
                        'duration' => $video['duration'],
                        'uri' => '//www.youtube.com/embed/'.substr($video['uri'], -11),
                    ]);
                }
            }

            return response()->json($vinyl);
        }

        flash()->error('Oops! There was an error adding the vinyl to the collection. Please try again.');

        return redirect()->route('get.search');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $vinyl = Vinyl::find($id);
        $user = $vinyl->user;
        $tracks = $vinyl->tracks;
        $videos = $vinyl->videos;

        return view('vinyl.show')
          ->with('vinyl', $vinyl)
          ->with('user', $user)
          ->with('tracks', $tracks)
          ->with('videos', $videos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $vinyl = Vinyl::find($id);
        $user = $vinyl->user;
        $tracks = $vinyl->tracks;

        return view('vinyl.edit')
      ->with('vinyl', $vinyl)
      ->with('user', $user)
      ->with('tracks', $tracks);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, EditVinylRequest $request)
    {
        $vinyl = Vinyl::find($id);
        $cover = '/images/PH_vinyl.svg';

    // uploaded vinyl cover or URL
    if ($request->hasFile('coverFile')) {
        $path = public_path().'/images/vinyls';
        $file = $request->file('coverFile');
        $filename = 'vinyl_'.time().'_'.$file->getClientOriginalName();
        $file->move($path, $filename);
        $cover = '/images/vinyls/'.$filename;
    } elseif ($request->input('artwork')) {
        $cover = $request->input('artwork');
    }

        $vinyl->artwork = $cover;
        $vinyl->artist = $request->input('artist');
        $vinyl->title = $request->input('title');
        $vinyl->label = $request->input('label');
        $vinyl->catno = $request->input('catno');
        $vinyl->genre = $request->input('genre');
        $vinyl->price = $request->input('price');
        $vinyl->country = $request->input('country');
        $vinyl->releasedate = $request->input('releasedate');
        $vinyl->size = $request->input('size');
        $vinyl->count = $request->input('count');
        $vinyl->type = $request->input('type');
        $vinyl->releasetype = $request->input('format');
        $vinyl->notes = $request->input('notes');
        $vinyl->weight = $request->input('weight');
        $vinyl->spotify_id = substr($request->input('spotify_id'), -22);

        if ($vinyl->save()) {
            $tracklistItems = $request->input('trackCount');

      // update existing tracks
      for ($i = 0; $i < $tracklistItems; ++$i) {
          $track = Track::find($request->input('track_'.$i.'_id'));

          if ($track) {
              $track->title = $request->input('track_'.$i.'_title');
              $track->number = $request->input('track_'.$i.'_position');
              $track->duration = $request->input('track_'.$i.'_duration');
              $track->save();
          } else {
              Track::create([
            'vinyl_id' => $vinyl->id,
            'artist' => $vinyl->artist,
            'title' => $request->input('track_'.$i.'_title'),
            'number' => $request->input('track_'.$i.'_position'),
            'duration' => $request->input('track_'.$i.'_duration'),
          ]);
          }
      }

            flash()->success('Success! Vinyl updated.');

            return redirect()->route('get.show.vinyl', $vinyl->id);
        }

        flash()->success('Oops! Could not edit vinyl. Please try again.');

        return redirect()->route('get.show.vinyl', $vinyl->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $vinyl = Vinyl::find($id);
        $owner = $vinyl->user;
        $currentUser = Auth::user();

        if($owner == $currentUser){
            if ($vinyl->delete()) {
                return "deleted";
            }
        }

        return response("Unauthorized", 401);
    }
}
