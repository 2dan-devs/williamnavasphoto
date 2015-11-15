<?php namespace App\Handlers\Commands;

use app\Commands\CreateClientUserCommand;
use Illuminate\Queue\InteractsWithQueue;
use App\User;
use App\Client;
use \Illuminate\Support\Facades\DB;

class CreateClientUserCommandHandler {

	/**
	 * Handle the command.
	 *
	 * @param  CreateClientUserCommand  $command
	 * @return void
	 */
	public function handle(CreateClientUserCommand $command)
	{
		//If photo uploaded correctly
		//Create user and client in DB
		DB::transaction(function() use($command)
		{	
			$user = User::create([
				'email'		=> $command->email,
				'password'	=> $command->password,
				]);
			$client = Client::create([
				'profile_photo' => $command->profile_photo,
				'first_name'	=> $command->first_name,
				'last_name'		=> $command->last_name,
				'user_id'		=> $user->id,
				'email'			=> $command->email,
				'phone_1'		=> $command->phone_1,
				'phone_2'		=> $command->phone_2,
				'address_1'		=> $command->address_1,
				'address_2'		=> $command->address_2,
				'city'			=> $command->city,
				'state'			=> $command->state,
				'zip'			=> $command->zip,
				]);
		});
	}

}
