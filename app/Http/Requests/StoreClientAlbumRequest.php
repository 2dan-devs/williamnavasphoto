<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreClientAlbumRequest extends Request {

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
			'album_cover_photo'		=> 'required|image',
			'album_name' 			=> 'required|MIN:3|MAX:25',
			'photo_selection_max' 	=> 'required|integer',
		];
	}

}
