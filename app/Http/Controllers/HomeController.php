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
		if(Auth::check()){
			$user = Auth::user();
			$latestVinyls = Vinyl::latest()->take(6)->get();
			$latestMembers = User::latest()->take(4)->get();

			$userIds = $user->following()->lists('follow_id');
			$activities = Vinyl::whereIn('user_id', $userIds)->latest()->get();
			$activitiesUsers = User::whereIn('id', $userIds)->latest()->get();

			return view('user.dashboard')
				->with('user', $user)
				->with('latestVinyls', $latestVinyls)
				->with('latestMembers', $latestMembers)
				->with('activities', $activities)
				->with('activitiesUsers', $activitiesUsers);
		}
		else{
			$userCount = User::all()->count();
			$vinylCount = Vinyl::all()->count();
			$latestVinyls = Vinyl::latest()->take(6)->get();
			$latestMembers = User::latest()->take(4)->get();

			return view('pages.home')
				->with('userCount', $userCount)
				->with('vinylCount', $vinylCount)
				->with('latestVinyls', $latestVinyls)
				->with('latestMembers', $latestMembers);
		}
	}
}
