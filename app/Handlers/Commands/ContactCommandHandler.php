<?php namespace App\Handlers\Commands;

use App\Commands\ContactCommand;

use Illuminate\Queue\InteractsWithQueue;
use App\Contact;

class ContactCommandHandler {

	/**
	 * Handle the command.
	 *
	 * @param  ContactCommand  $command
	 * @return void
	 */
	public function handle(ContactCommand $command)
	{
		$contact = Contact::find($command->id);
		$contact->title = $command->title;
		$contact->address = $command->address;
		$contact->city = $command->city;
		$contact->state = $command->state;
		$contact->zip = $command->zip;
		$contact->email = $command->email;
		$contact->phone = $command->phone;
		$contact->save();
	}

}
