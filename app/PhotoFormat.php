<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoFormat extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'photo_format';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['format'];

	public $timestamps = false;

}
