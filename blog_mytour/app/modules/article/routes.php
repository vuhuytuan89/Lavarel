<?php
	Route::get('tat-ca-bai-viet.html',  array('as' => 'allarticle', 'uses' => 'App\Modules\Article\Controllers\ArticleController@allnewarticle'));
	Route::get('bai-viet-moi-nhat.html',  array('as' => 'allnewarticle', 'uses' => 'App\Modules\Article\Controllers\ArticleController@allnewarticle'));
	Route::any('dang-bai.html',  array('before' => 'authpostnews', 'uses' => 'App\Modules\Article\Controllers\ArticleController@postarticle'));
	Route::get('danh-muc/{id}-{title}',  array('before' => 'catCheckMytour', 'uses' => 'App\Modules\Article\Controllers\ArticleController@catarticle'))
		->where(array('id' => '[0-9]+'))
	;
	Route::get('bai-viet/{id}-{title}',  array('before' => 'articleCheckMytour', 'uses' => 'App\Modules\Article\Controllers\ArticleController@detailarticle'))
		->where(array('id' => '[0-9]+'))
	;
	Route::post('checktitle',  array('as' => 'checktitle', 'uses' => 'App\Modules\Article\Controllers\ArticleController@ajaxchecktitle'));
	Route::any('tim-kiem.html', array('as' =>'search',     'uses' => 'App\Modules\Article\Controllers\ArticleController@search'));



