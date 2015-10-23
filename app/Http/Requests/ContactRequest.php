<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ContactRequest extends Request {

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
			'title' 	=> 'required|MIN:3|MAX:25',
			'address' 	=> 'required|MIN:3|MAX:100',
			'city' 	    => 'required|MIN:3|MAX:50',
			'state' 	=> 'required|MIN:2|MAX:2',
			'zip' 	    => 'required|MIN:3|MAX:10',
			'email' 	=> 'required|email|MAX:100',
			'phone' 	=> 'required|MIN:10|MAX:16',
		];
	}

}
