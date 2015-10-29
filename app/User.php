<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password', 'password_temp', 'name', 'image', 'location', 'website', 'description', 'currency', 'discogs_uri', 'code', 'active', 'remember_token', 'discogs_access_token', 'discogs_access_token_secret', 'discogs_username'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'password_temp', 'remember_token', 'discogs_access_token', 'discogs_access_token_secret'];

	/**
	 * Followers
	 */
	public function followers()
	{
	  return $this->belongsToMany('App\User', 'followers', 'follow_id', 'user_id')->withTimestamps();
	}

	/**
	 * Following
	 */
	public function following(){
		return $this->belongsToMany('App\User', 'followers', 'user_id', 'follow_id')->withTimestamps();
	}

	/**
	 *	Check if followed by other User (boolean)
	 */
	public function isFollowedBy($otherUser){
		$ids = $otherUser->following()->lists('follow_id')->toArray();
		return in_array($this->id, $ids);
	}

	/**
	 *	Vinyls
	 */
	public function vinyls(){
		return $this->hasMany('App\Vinyl');
	}


}
