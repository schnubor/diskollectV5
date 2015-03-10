<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SessionsController extends Controller {

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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('auth.login');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LoginRequest $request)
	{
		$remember = ($request->has('remember')) ? true : false; // set remember cookie

		if (Auth::attempt($request->only('username', 'password'), $remember))
		{
			if(Auth::user()->active == 1){
				flash()->success('Welcome back '.Auth::user()->username.'!');
				return redirect()->intended(route('home'));
			}
			else{
				Auth::logout();
				flash()->warning('Your account is not activated. Please check your emails.');
				return redirect()->route('login');
			}
		}
		else{
			flash()->error('Wrong password.');
			return redirect()->route('login');
		}

		flash()->error('Sorry! Please try again.');
		return redirect()->route('login');
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
	public function destroy()
	{
		Auth::logout();
		flash()->info('You are now signed out.');
		return redirect()->route('home');
	}

}
