<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClientAuthRequest extends Request {

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
            'password' => 'required'
        ];
	}

    public function messages()
    {
        return [
            'password.required' => 'Enter password',
            'email.required'    => 'Enter Account name',
            'email.email'       => 'Invalid email'
        ];
    }

}
