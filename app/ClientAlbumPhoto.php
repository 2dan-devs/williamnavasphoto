<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAlbumPhoto extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'client_album_photos';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['photo_path_low_res','photo_path_high_res','client_album_id'];

	public $timestamps = false;

	/*****************Relationships******************/

	public function album()
	{
		return $this->belongsTo('App\ClientAlbum');
	}

}
