<?php namespace App\Http\Controllers;

use App\User;
use App\Vinyl;
use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\EditPasswordRequest;
use App\Http\Requests\EditNotificationsRequest;
use App\Http\Requests\EditPrivacyRequest;
use App\Http\Requests\EditProfileRequest;
use App\Http\Controllers\Controller;
use Mail;
use Hash;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::orderBy('created_at', 'DESC')->paginate(12);
		return view('user.index')
			->with('users', $users);
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
				$message->to($user->email, $user->username)->subject('Account Activation');
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
		$user = User::findOrFail($id);
		$vinyls = $user->vinyls();

		// Overall value
		$value = number_format(round($vinyls->sum('price'),2),2);

		// Overall weight
		$weight = ($vinyls->sum('weight')) / 1000;

		// Fav artist
		$favArtist = DB::table('vinyls')
			->select(DB::raw('count(*) as artist_count, artist'))
			->where('user_id', '=', $id)
			->groupBy('artist')
			->orderBy('artist_count','DESC')
			->first();

		// Fav Label
		$favLabel = DB::table('vinyls')
			->select(DB::raw('count(*) as label_count, label'))
			->where('user_id', '=', $id)
			->groupBy('label')
			->orderBy('label_count','DESC')
			->first();

		// Most valuable vinyl
		$valueVinylQuery = DB::table('vinyls')
			->select(DB::raw('id, max(`price`)'))
			->where('user_id', '=', $id)
			->groupBy('id')
			->orderBy('price','DESC')
			->first();

		if(isset($valueVinylQuery)){
			$valueVinyl = $vinyls->find($valueVinylQuery->id);
		}
		else{
			$valueVinyl = NULL;
		}

		return view('user.show')
			->with('user', $user)
			->with('weight', $weight)
			->with('favArtist', $favArtist)
			->with('favLabel', $favLabel)
			->with('valueVinyl', $valueVinyl)
			->with('value', $value);
	}

	/**
	 * Display users collection.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function collection($id)
	{
		$user = User::findOrFail($id);
		$vinyls = $user->vinyls()->orderBy('created_at', 'DESC')->paginate(8);

		return view('user.collection')
			->with('user', $user)
			->with('vinyls', $vinyls);
	}

	/**
	 * Display users jukebox.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function jukebox($id)
	{
		$user = User::findOrFail($id);
		$vinyls = $user->vinyls()->with('videos')->has('videos')->get();

		return view('user.jukebox')
			->with('user', $user)
			->with('vinyls', $vinyls);
	}

	/**
	 * Display followers of user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function followers($id)
	{
		$user = User::find($id);
		$followers = $user->followers()->orderBy('created_at', 'DESC')->paginate(12);
		return view('user.follower')
			->with('user', $user)
			->with('followers', $followers);
	}

	/**
	 * Display users followed by user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function following($id)
	{
		$user = User::find($id);
		$followings = $user->following()->orderBy('created_at', 'DESC')->paginate(12);
		return view('user.following')
			->with('user', $user)
			->with('followings', $followings);
	}

	/**
	 * Show user settings.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function settings()
	{
		return view('user.settings');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EditProfileRequest $request)
	{
		$user = User::findOrFail(Auth::user()->id);

		if($request->hasFile('avatar')){
			$path = public_path() . '/images/users';
			$file = $request->file('avatar');
			$filename = 'user_' . Auth::user()->id . '_' . $file->getClientOriginalName();
			$file->move($path,$filename);
			$user->image = '/images/users/' . $filename;
		}
		$user->name = $request->input('name');
		$user->location = $request->input('location');
		$user->website = $request->input('website');
		$user->description = $request->input('description');
		$user->currency = $request->input('currency');

		if($user->save()){
			flash()->success('Profile updated successfully!');
			return redirect()->route('user.settings', Auth::user()->id);
		}

		flash()->error('Sorry! Please try again.');
		return redirect()->route('user.settings', Auth::user()->id);
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
					$message->to($user->email, $user->username)->subject('Password Recovery');
				});

				flash()->info('We have sent you an email with your new password.');
				return redirect()->route('home');
			}

			flash()->error('Sorry! Please try again.');
			return redirect()->route('password');
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
				return redirect()->route('user.settings', Auth::user()->id);
			}

			flash()->error('Sorry! Please try again.');
			return redirect()->route('user.settings', Auth::user()->id);
		}

		flash()->error('Wrong password.');
		return redirect()->route('user.settings', Auth::user()->id);
	}

	/**
	 * POST edit notificiations form
	 **/

	public function postEditNotifications(EditNotificationsRequest $request){
		$user = User::find(Auth::user()->id);
		$email_new_follower = $request->input('email_new_follower');

		if($email_new_follower === 'on'){
			$user->email_new_follower = 1;
		}
		else{
			$user->email_new_follower = 0;
		}

		if($user->save()){
			flash()->success('You successfully updated your notification settings.');
			return redirect()->route('user.settings', Auth::user());
		}

		flash()->error('Wrong password.');
		return redirect()->route('user.settings', Auth::user()->id);
	}

	/**
	 * POST edit privacy form
	 **/

	public function postEditPrivacy(EditPrivacyRequest $request){
		$user = User::find(Auth::user()->id);

		$user->collection_visibility = $request->input('collection_visibility');
		$user->statistics_visibility = $request->input('statistics_visibility');

		if($user->save()){
			flash()->success('You successfully updated your notification settings.');
			return redirect()->route('user.settings', Auth::user());
		}

		flash()->error('Wrong password.');
		return redirect()->route('user.settings', Auth::user()->id);
	}

}
