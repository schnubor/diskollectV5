<?php namespace App\Http\Controllers;

use App\User;
use App\Vinyl;
use App\Video;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Discogs;
use GuzzleHttp;
use League;
use Illuminate\Http\Request;
use Auth;

class ApiController extends Controller {

    /**
     * Return currently signed in user
     *
     * @return Response
     */
    public function me(){
      $user = Auth::user();
      return $user;
    }

  /**
   * Return vinyls of user as JSON (paginated)
   *
   * @return Response
   */
  public function vinyls($id){
    $user = User::find($id);
    $vinyls = $user->vinyls()->latest()->paginate(20);
    return $vinyls;
  }

  /**
   * Return vinyls of user as JSON
   *
   * @return Response
   */
  public function vinylsAll($id){
    $user = User::find($id);
    $vinyls = $user->vinyls()->latest()->get();
    return $vinyls;
  }

  /**
   * Return vinyls of user that have videos as JSON
   *
   * @return Response
   */
  public function vinylsWithVideosAll($id){
      $user = User::findOrFail($id);
      $vinyls = $user->vinyls()->with('videos')->has('videos')->get();
    return $vinyls;
  }

  /**
   * Return videos of vinyl as JSON
   *
   * @return Response
   */
  public function videos($id){
    $vinyl = Vinyl::find($id);
    $videos = $vinyl->videos;
    return $videos;
  }

  /**
   * Return tracks of vinyl as JSON
   *
   * @return Response
   */
  public function tracks($id){
    $vinyl = Vinyl::find($id);
    $tracks = $vinyl->tracks;
    return $tracks;
  }

  /**
   * Return Discogs Connection status
   *
   * @return Response
   */
  public function connectionStatus($id){
    $user = User::find($id);
    $client = Discogs\ClientFactory::factory([
      'defaults' => [
        'headers' => ['User-Agent' => 'therecord/0.1 +https://therecord.de'],
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

    // check if discogs tokens are valid
    $identity = $client->getOAuthIdentity();

    return $identity['username'];
  }

  /**
   * Get release ID from Discogs
   *
   * @return Response
   */
  public function getDiscogsId($id){
    $user = Auth::user();

    $client = Discogs\ClientFactory::factory([
    'defaults' => [
       'headers' => ['User-Agent' => 'therecord/0.1 +https://therecord.de'],
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

    $data = $client->getRelease(['id' => $id, 'curr_abbr' => $user->currency]);

    return $data;
  }

  /**
   * Get release ID from Discogs Marketplace
   *
   * @return Response
   */
  public function getDiscogsMarketplaceId($id){
    $user = Auth::user();

    $client = Discogs\ClientFactory::factory([
        'defaults' => [
           'headers' => ['User-Agent' => 'therecord/0.1 +https://therecord.de'],
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

    $data = $client->marketplaceSearch(['release_id' => $id]);

    return $data;
  }

  /**
   * Get ID from Discogs
   *
   * @return Response
   */
  public function getDiscogsUserReleases($username, $page){
    $user = Auth::user();

    $client = Discogs\ClientFactory::factory([
        'defaults' => [
           'headers' => ['User-Agent' => 'therecord/0.1 +https://therecord.de'],
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

    $data = $client->getCollectionItemsByFolder(['username' => $username, 'folder_id' => 0, 'per_page' => 100, 'page' => intval($page)]);

    return $data;
  }
}
