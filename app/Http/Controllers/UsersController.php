<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\EditPasswordRequest;
use App\Http\Controllers\Controller;
use Mail;
use Hash;
use Auth;

use Illuminate\Http\Request;

class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return "all the users";
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('auth.register');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(RegisterRequest $request)
	{
		// Create account
		$email 		= $request->input('email');
		$username = $request->input('username');
		$password = $request->input('password');
		$currency = $request->input('currency');

		$code = str_random(60);

		$user = User::create(array(
			'email' => $email,
			'username' => e($username),
			'image' => config('constants.USER_PH_PATH'),
			'currency' => $currency,
			'password' => bcrypt($password),
			'code' => $code,
			'active' => 0
		));

		if($user){
			Mail::send('emails.activation', [
				'link' => route('user.activate', $code), 
				'username' => $username
			], function($message) use ($user){
					$message->to($user->email, $user->username)->subject('Diskollect Account Activation');
			});

			flash()->success('Almost done! Please check your emails in order to activate your account.');
			return redirect()->route('home');
		}

		flash()->error('Sorry! Please try again.');
		return redirect()->route('home');
	}

	/**
	 * Active User Account
	 * GET /users/activate
	 *
	 * @return Response
	 */

	public function activate($code)
	{
		$user = User::where('code', '=', $code)->where('active', '=', 0);

		if($user->count()){
			$user = $user->first();

			// Update user to active state

			$user->active = 1;
			$user->code = '';

			if($user->save()){
				flash()->success('Your account has been activated! You may now sign in.');
				return redirect()->route('login');
			}
		}

		flash()->error('User not found.');
		return redirect()->route('register');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return User::findOrFail($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::findOrFail($id);
		return view('user.edit');
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

	/**
	 * Get lost password form
	 */

	public function getPassword(){
		return view('user.recover');
	}

	/**
	 * Email new password
	 */

	public function postPassword(PasswordRequest $request){
		$email = $request->input('email');

		$user = User::where('email', '=', $email);

		if($user->count()){
			$user = $user->first();

			$username = $user->username;

			$code = str_random(60);
			$password = str_random(10);

			$user->code = $code;
			$user->password_temp = bcrypt($password);

			if($user->save()){
				Mail::send('emails.password', [
					'link' => route('recover', $code),
					'username' => $username,
					'password' => $password
				], function($message) use ($user){
					$message->to($user->email, $user->username)->subject('Diskollect Password Recovery');
				});

				flash()->info('We have sent you an email with your new password.');
				return redirect()->route('home');
			}

			flash()->error('Sorry! Please try again.');
			return reidrect()->route('password');
		}

		flash()->error('User not found.');
		return redirect()->route('home');
	}

	/**
	 * Recover password
	 */

	public function recover($code){
		$user = User::where('code', '=', $code)->where('password_temp','!=','');

		if($user->count()){
			$user = $user->first();

			$user->password = $user->password_temp;
			$user->password_temp = '';
			$user->code = '';

			if($user->save()){
				flash()->info('You may now log in with your new password.');
				return redirect()->route('login');
			}

			flash()->error('Sorry! Please try again.');
			return redirect()->route('home');
		}

		flash()->error('User not found.');
		return redirect()->route('home');
	}

	/**
	 * GET edit password form
	 **/

	public function getEditPassword(){
		return view('user.password');
	}

	/**
	 * POST edit password form
	 **/

	public function postEditPassword(EditPasswordRequest $request){
		$user = User::find(Auth::user()->id);

		$old = $request->input('old');
		$new = $request->input('new');

		if(Hash::check($old, $user->getAuthPassword())){
			$user->password = bcrypt($new);

			if($user->save()){
				flash()->success('You successfully changed your password.');
				return redirect()->route('home');
			}

			flash()->error('Sorry! Please try again.');
			return redirect()->route('home');
		}

		flash()->error('Wrong password.');
		return redirect()->route('get.edit.password');
	}

}
