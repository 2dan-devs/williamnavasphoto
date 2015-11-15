<?php namespace App\Handlers\Commands;

use App\Commands\AboutCommand;

use Illuminate\Queue\InteractsWithQueue;

use App\About;

class AboutCommandHandler {

	/**
	 * Handle the command.
	 *
	 * @param  AboutCommand  $command
	 * @return void
	 */
	public function handle(AboutCommand $command)
	{
		$about = About::find($command->id);
		$about->body = $command->body;
		$about->title = $command->title;
		$about->save();
	}

}
