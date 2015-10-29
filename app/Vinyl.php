<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Vinyl extends Model {
  
	/**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'vinyls';

  protected $fillable = ['user_id','artwork','artist','title','label','genre','price','videos','tracklist','country','size','count','color','type','catno','releasedate','releasetype','notes','weight', 'discogs_uri', 'release_id', 'spotify_id'];

  /**
   * Owner
   */
  public function user(){
    return $this->belongsTo('App\User');
  }

  /**
   * Tracks
   */
  public function tracks()
  {
      return $this->hasMany('App\Track');
  }

  /**
   * Videos
   */
  public function videos()
  {
      return $this->hasMany('App\Video');
  }

}
