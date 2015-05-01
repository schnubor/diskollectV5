<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditVinylRequest extends Request {

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
      'artist' => 'required',
      'title' => 'required',
      'price' => 'required',
      'coverFile' => 'image|max:200'
    ];
  }

}
