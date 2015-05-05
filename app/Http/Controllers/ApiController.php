<?php namespace App\Http\Controllers;

use App\User;
use App\Vinyl;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ApiController extends Controller {

    /**
     * Return user collections genre amounts as JSON
     *
     * @return Response
     */
	public function vinyls($id){
        $user = User::find($id);
        $vinyls = $user->vinyls;
        return $vinyls;
    }

}
