<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AchievementsRequest extends Request {

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
			'title'         => 'required',
            'points'        => 'required|integer',
            'difficulty'    => 'required',
            'category'      => 'required',
            'criteria_text' => 'required',
            'criteria_value'=> 'required',
            'criteria'      => 'required'
		];
	}

}
