<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateClientUserRequest extends Request {

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
			'profile_photo'	=> 'image',
			'first_name' 	=> 'required|MIN:3|MAX:25',
			'last_name' 	=> 'required|MIN:3|MAX:25',
			'email'			=> 'required|email|MAX:100',
			'phone_1'		=> 'required|MIN:10|MAX:12',
			'phone_2'		=> 'MIN:10|MAX:12',
			'address_1'		=> 'required|MIN:6|MAX:100',
			'address_2'		=> 'MIN:6|MAX:100',
			'city'			=> 'required|MIN:3|MAX:30',
			'state'			=> 'required|MIN:2|MAX:2',
			'zip'			=> 'required|MIN:5|MAX:10',
			'password'		=> 'MIN:3|MAX:15',
			'is_active'		=> 'boolean',
		];
	}

}
