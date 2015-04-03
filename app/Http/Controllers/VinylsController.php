<?php namespace App\Http\Controllers;

use App\Vinyl;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class VinylsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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

	public function result(){
		$user = Auth::user();
		
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
        array_push($results, $release);
      }
      else{ // Master
        $master = $client->getMaster([
          'id' => $result['id']
        ]);
        $master['type'] = 'master';
        array_push($results, $master);
      }
    }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
		//
	}

}
