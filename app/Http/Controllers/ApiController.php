<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ApiController extends Controller {

    /**
     * Return user collections genre amounts as JSON
     *
     * @return Response
     */
	public function genres($id){
        $user = User::find($id);
        
        return $user;
    }

}
