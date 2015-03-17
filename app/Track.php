<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model {

	/**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'tracks';

  protected $fillable = ['vinyl_id','artist_id','number','title','artist','duration'];

  /**
   * Vinyl
   */
  public function vinyl(){
    return $this->belongsTo('Vinyl');
  }

}
