<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'orders';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['client_id','client_album_id','status','type'];

	/*****************Relationships******************/

	public function client()
	{
		return $this->belongsTo('App\Client','client_id','id');
	}

	public function album()
	{
		return $this->belongsTo('App\ClientAlbum','client_album_id','id');
	}

	public function albumSelections()
	{
		return $this->hasMany('App\ClientAlbumSelection','album_order_id','id');
	}

	public function printsSelections()
	{
		return $this->hasMany('App\ClientPrintsSelection','print_order_id','id');
	}

}
