<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditNotificationsRequest extends Request
{
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
        $this->merge(['email_new_follower' => $this->input('email_new_follower', 0)]);
        return [
            //
        ];
    }
}
