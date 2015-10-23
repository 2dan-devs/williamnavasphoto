<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAlbumSelection extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'client_album_selections';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/*****************Relationships******************/

	public function photo()
	{
		return $this->belongsTo('App\ClientAlbumPhoto','client_album_photo_id','id');
	}

	
}
