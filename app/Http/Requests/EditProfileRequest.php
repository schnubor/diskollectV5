<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditProfileRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'currency' => 'required',
			'description' => 'max:255',
			'name' => 'max:60',
			'website' => 'max:60',
			'location' => 'max:60'
		];
	}

}
