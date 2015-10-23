<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Client extends Model {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'clients';

	//Disable timestamps
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['profile_photo','first_name','last_name',
							'email','phone_1','phone_2','address_1',
							'address_2','city','state','zip','active',
							'user_id'];

	/*****************Relationships******************/
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function albums()
	{
		return $this->hasMany('App\ClientAlbum','client_id','id');
	}

	public function orders()
	{
		return $this->hasMany('App\Order','client_id','id');
	}
}
