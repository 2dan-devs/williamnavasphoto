<?php namespace App\Commands;

use App\Commands\Command;

class DeleteFolderFileCommand extends Command {

	public $path;
	
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($path)
	{
		$this->path = $path;
	}
}
