<?php namespace App\Handlers\Commands;

use App\Commands\DeleteFolderFileCommand;

use Illuminate\Queue\InteractsWithQueue;

class DeleteFolderFileCommandHandler {
	/**
	 * Handle the command.
	 * Command handler deletes folder or files.
	 * @param  DeleteCommand  $command
	 * @return void
	 */
	public function handle(DeleteFolderFileCommand $command)
	{
		$this->delete($command->path);
	}

	public function delete($path)
	{
	    if (is_dir($path) === true)
	    {
	        $files = array_diff(scandir($path), array('.', '..'));

	        foreach ($files as $file)
	        {
	            $this->Delete(realpath($path) . '/' . $file);
	        }

	        return rmdir($path);
	    }

	    else if (is_file($path) === true)
	    {
	        return unlink($path);
	    }

	    return false;
	}
}
