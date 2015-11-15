<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAlbum extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'client_albums';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['album_name','album_cover_photo','client_id',
							'photo_selection_max'];

	/*****************Relationships******************/

	public function client()
	{
		return $this->belongsTo('App\Client');
	}

	public function photos()
	{
		return $this->hasMany('App\ClientAlbumPhoto');
	}

	public function orders()
	{
		return $this->hasMany('App\Order','client_album_id','id');
	}

}
