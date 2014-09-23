<?php namespace App\Modules\Notify;

class NotifyServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		\Log::debug("NotifyServiceProvider registered");
	}

}
