<?php namespace App\Http\Controllers;

use App\User;
use App\Vinyl;
use App\Video;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ApiController extends Controller {

    /**
     * Return vinyls of user as JSON
     *
     * @return Response
     */
	public function vinyls($id){
        $user = User::find($id);
        $vinyls = $user->vinyls;
        return $vinyls;
    }

    /**
     * Return videos of vinyl as JSON
     *
     * @return Response
     */
    public function videos($id){
        $vinyl = Vinyl::find($id);
        $videos = $vinyl->videos;
        return $videos;
    }

    /**
     * Return tracks of vinyl as JSON
     *
     * @return Response
     */
    public function tracks($id){
        $vinyl = Vinyl::find($id);
        $tracks = $vinyl->tracks;
        return $tracks;
    }
}
