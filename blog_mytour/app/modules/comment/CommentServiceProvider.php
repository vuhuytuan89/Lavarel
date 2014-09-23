<?php namespace App\Modules\Comment;

class CommentServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		\Log::debug("CommentServiceProvider registered");
	}

}
