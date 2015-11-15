<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contact';

	//Disable timestamps
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['title','address','city','state',
							'zip','email','phone'];

	
}
