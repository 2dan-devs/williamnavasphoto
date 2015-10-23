<?php namespace App\helpers;

############## Helper Function for Flash Messages ###########

class FlashMessage
{
	public static function DisplayAlert($message, $type)
	{
		return '<div class="alert-box radius ' .$type. '">' .$message. '<a class="fa fa-large fa-times fa-inverse right" id="session-message-alert"></a></div>';
	}
}