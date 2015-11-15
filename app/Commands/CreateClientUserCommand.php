<?php namespace App\Commands;

use App\Commands\Command;

class CreateClientUserCommand extends Command {

	public $profile_photo;
	public $first_name;
	public $last_name;
	public $email;
	public $phone_1;
	public $phone_2;
	public $address_1;
	public $address_2;
	public $city;
	public $state;
	public $zip;
	public $password;

	
	public function __construct($profile_photo,$first_name,$last_name,
								$email,$phone_1,$phone_2,$address_1,
								$address_2,$city,$state,$zip,$password)
	{
		$this->profile_photo = $profile_photo;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->email = $email;
		$this->phone_1 = $phone_1;
		$this->phone_2 = $phone_2;
		$this->address_1 = $address_1;
		$this->address_2 = $address_2;
		$this->city = $city;
		$this->state = $state;
		$this->zip = $zip;
		$this->password = $password;
	}



}
