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

class ApiController extends Controller {

  /**
   * Return vinyls of user as JSON
   *
   * @return Response
   */
  public function vinyls($id){
    $user = User::find($id);
    $vinyls = $user->vinyls()->latest()->paginate(12);
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

    // check if discogs tokens are valid
    $identity = $client->getOAuthIdentity();

    return $identity['username'];
  }
}
