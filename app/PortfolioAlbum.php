<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioAlbum extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'portfolio_albums';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name'];

	/*****************Relationships******************/

	public function photos()
	{
		return $this->hasMany('App\PortfolioAlbumPhoto');
	}
}
