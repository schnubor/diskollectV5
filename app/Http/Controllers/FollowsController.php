<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FollowRequest;
use App\User;
use Auth;
use Mail;

class FollowsController extends Controller {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(FollowRequest $request)
	{
		$user = User::find(Auth::user()->id);
		$userToFollow = User::find($request->input('userIdToFollow'));

		$user->following()->save($userToFollow);

		Mail::send('emails.follow', [
			'username' => $userToFollow->username,
			'follower' => $user,
		], function($message) use ($userToFollow){
			$message->to($userToFollow->email, $userToFollow->username)->subject('New Follower');
		});

		flash()->success('You are now following '.$userToFollow->username.'.');
		return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Auth::user()->following()->detach($id);

		$user = User::find($id);
		flash()->info('You unfollowed '.$user->username.'.');
		return redirect()->back();
	}

}
