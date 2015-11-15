<?php namespace App\Commands;

use App\Commands\Command;

class ContactCommand extends Command {

	public $id;
	public $title;
	public $address;
	public $city;
	public $state;
	public $zip;
	public $email;
	public $phone;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($id,$title,$address,$city,$state,$zip,$email,$phone)
	{
		$this->id = $id;
		$this->title = $title;
		$this->address = $address;
		$this->city = $city;
		$this->state = $state;
		$this->zip = $zip;
		$this->email = $email;
		$this->phone = $phone;
	}

}
