<?php namespace App\Modules\Article;

class ArticleServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		\Log::debug("ArticleServiceProvider registered");
	}

}
