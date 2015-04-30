<?php namespace App\Http\Controllers;

use App\Vinyl;
use App\Track;
use App\User;
use Discogs;
use GuzzleHttp;
use League;
use App\Http\Requests;
use App\Http\Requests\DiscogsOAuthRequest;
use App\Http\Requests\DiscogsSearchRequest;
use App\Http\Requests\StoreVinylRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;

class VinylsController extends Controller {

	/**
	 * Authorize with Discogs
	 *
	 * @return Response
	 */
	public function oAuthDiscogs(DiscogsOAuthRequest $request){
		// oAuth to Discogs to enable search
    $userAgent = 'Diskollect/1.0, +http://diskollect.com';  // specify recognizable user-agent

    $server = new \League\OAuth1\Client\Server\Discogs([
      'identifier'   => env('DC_CONSUMER_KEY'),
      'secret'       => env('DC_CONSUMER_SECRET'),
      'callback_uri' => 'http://'.$_SERVER['HTTP_HOST'].dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/discogs'
    ], null, $userAgent);

    // no temporary token? redirect then
    if ( !isset($_GET['oauth_token']) ) {
      $tempCredentials = $server->getTemporaryCredentials();
      Session::put('tempCredentials', serialize($tempCredentials));
      Session::save();
      header('Location: '.$server->getAuthorizationUrl($tempCredentials));
      $server->authorize($tempCredentials);
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
      'consumer_key'    => env('DC_CONSUMER_KEY'), // from Discogs developer page
      'consumer_secret' => env('DC_CONSUMER_SECRET'), // from Discogs developer page
      'token'           => $token->getIdentifier(), // get this using a OAuth library
      'token_secret'    => $token->getSecret() // get this using a OAuth library
    ]);
    $client->getHttpClient()->getEmitter()->attach($oauth);
    $identity = $client->getOAuthIdentity();

    $user = Auth::user(); // Current user
    $user->discogs_access_token = $token->getIdentifier();
    $user->discogs_access_token_secret = $token->getSecret();
    $user->discogs_uri = $identity['resource_url'];

    if($user->save()){
    	flash()->success('Success! You are now authenticated with Discogs.');
    	return redirect()->route('get.search');
    }
    else{
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
	 * Receive search results
	 *
	 * @return Response
	 */
	public function result(DiscogsSearchRequest $request){
		$user = Auth::user();
		$artist = $request->input('artist');
		$title = $request->input('title');
		$catno = $request->input('catno');

		$client = Discogs\ClientFactory::factory([
	    'defaults' => [
	       'headers' => ['User-Agent' => 'Diskollect/0.1 +https://www.diskollect.com'],
	    ]
		]);
		$client->getHttpClient()->getEmitter()->attach(new Discogs\Subscriber\ThrottleSubscriber());

		$oauth = new GuzzleHttp\Subscriber\Oauth\Oauth1([
      'consumer_key'    => env('DC_CONSUMER_KEY'), // from Discogs developer page
      'consumer_secret' => env('DC_CONSUMER_SECRET'), // from Discogs developer page
      'token'           => $user->discogs_access_token, // get this using a OAuth library
      'token_secret'    => $user->discogs_access_token_secret // get this using a OAuth library
    ]);
    $client->getHttpClient()->getEmitter()->attach($oauth);

		$response = $client->search([
      'artist' => $artist,
      'title' => $title,
      'catno' => $catno,
      'format' => 'vinyl'
    ]);

    $results = [];

    // check if discogs tokens are valid
    $identity = $client->getOAuthIdentity();

    foreach($response['results'] as $result){
      if($result['type'] == 'release'){ // Release
        $release = $client->getRelease([
          'id' => $result['id']
        ]);
        $release['type'] = 'release';
        array_push($results, $release->toArray());
      }
      else{ // Master
        $master = $client->getMaster([
          'id' => $result['id']
        ]);
        $master['type'] = 'master';
        array_push($results, $master->toArray());
      }
    }
    //dd($results);
    return $results;
	}

  /**
   * Add vinyl from search results with "edit and add".
   *
   * @return Response
   */
  public function add()
  {
    // return create form with infos
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
		$user =  Auth::user();
    $cover = '/images/PH_vinyl.svg';  // default cover

    // uploaded vinyl cover or URL
    if($request->hasFile('coverFile')){
      $path = public_path() . '/images/vinyls';
      $file = $request->file('coverFile');
      $filename = 'vinyl_' . rand(0,9999999) . '_' . $file->getClientOriginalName();
      $file->move($path,$filename);
      $cover = '/images/vinyls/' . $filename;
    }
    elseif($request->input('cover')){
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
      'releasetype' => $request->input('format')
    ]);

    if($vinyl){
      $tracklistItems = $request->input('trackCount');
      for($i = 0; $i < $tracklistItems; $i++){
        Track::create([
          'vinyl_id' => $vinyl->id,
          'artist_id' => 1,
          'artist' => $vinyl->artist,
          'title' => $request->input('track_'.$i.'_title'),
          'number' => $request->input('track_'.$i.'_position'),
          'duration' => $request->input('track_'.$i.'_duration'),
        ]);
      }

      flash()->success('Success! '.$request->input('artist').' - '.$request->input('title').' is now in your collection.');
      return redirect()->route('user.collection', $user->id);
    }

    flash()->error('Oops! There was an error adding the vinyl to the collection. Please try again.');
    return redirect()->route('get.search');
  }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
    $vinyl = Vinyl::find($id);
    $user = $vinyl->user;
    $tracks = $vinyl->tracks;

		return view('vinyl.show')
      ->with('vinyl', $vinyl)
      ->with('user', $user)
      ->with('tracks', $tracks);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return 'edit';
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$vinyl = Vinyl::find($id);
    if($vinyl->delete()){
      flash()->info($vinyl->artist.' - '.$vinyl->title.' was deleted successfully.');
      return redirect()->route('user.collection', Auth::user()->id )
        ->with('info-alert', 'All done! Vinyl deleted successfully.');
    }
    else{
      flash()->error('Oops! Could not delete vinyl. Please try again.');
      return redirect()->route('user.collection', Auth::user()->id )
        ->with('danger-alert', 'Oops! Vinyl could not be deleted.');
    }
	}
}
