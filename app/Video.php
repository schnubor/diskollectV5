<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model {

	/**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'videos';

  protected $fillable = ['vinyl_id','title','duration','uri'];

  /**
   * Vinyl
   */
  public function vinyl(){
    return $this->belongsTo('App\Vinyl');
  }

}
