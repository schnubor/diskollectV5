<?php namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Vinyl;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Auth::user();
		$userCount = User::all()->count();
		$vinylCount = Vinyl::all()->count();
		$latestVinyls = Vinyl::orderBy('created_at', 'DESC')->take(6)->get();
		$latestMembers = User::orderBy('created_at', 'DESC')->take(4)->get();

		return view('pages.home')
			->with('user', $user)
			->with('userCount', $userCount)
			->with('vinylCount', $vinylCount)
			->with('latestVinyls', $latestVinyls)
			->with('latestMembers', $latestMembers);
	}

}
