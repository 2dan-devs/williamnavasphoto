<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioAlbumPhoto extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'portfolio_album_photos';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['photo_path','portfolio_album_id'];

	public $timestamps = false;
}
