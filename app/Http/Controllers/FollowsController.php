<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FollowRequest;
use App\User;
use Auth;


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
		//
	}

}
