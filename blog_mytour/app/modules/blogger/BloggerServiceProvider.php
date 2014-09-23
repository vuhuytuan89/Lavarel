<?php namespace App\Modules\Blogger;

class BloggerServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		\Log::debug("BloggerServiceProvider registered");
	}

}
