<?php namespace App\Commands;

use App\Commands\Command;

class AboutCommand extends Command {

	public $id;
	public $title;
	public $body;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($id,$title,$body)
	{
		$this->id = $id;
		$this->title = $title;
		$this->body = $body;
	}

}
