<?php
	Route::any('ajaxloadcomment/{page?}',  array('uses' => 'App\Modules\Comment\Controllers\CommentController@ajaxLoadComment'));
	Route::post('ajaxloadmorecomment',  array('as' => 'ajaxloadmorecomment', 'uses' => 'App\Modules\Comment\Controllers\CommentController@ajaxLoadMoreComment'));
	Route::post('ajaxpagingcomment/{page?}',  array('uses' => 'App\Modules\Comment\Controllers\CommentController@ajaxLoadPagingComment'));
