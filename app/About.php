<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'about';

	//Disable timestamps
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['title','body'];

	
}
