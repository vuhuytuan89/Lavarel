<?php
Route::group(array('prefix' => 'blogger'), function(){
	Route::get('profile/{username}',  array('as' => 'homeblogger', 'uses' => 'App\Modules\Blogger\Controllers\BloggerController@homepage'));
	Route::get('sua-profile.html',  array('before' => 'authnotlogin', 'uses' => 'App\Modules\Blogger\Controllers\BloggerController@get_profile'));
	Route::post('sua-profile.html',  array('as' => 'profile.post', 'uses' => 'App\Modules\Blogger\Controllers\BloggerController@post_profile'));
	Route::get('quan-ly-bai-viet.html',  array('before' => 'authnotlogin', 'uses' => 'App\Modules\Blogger\Controllers\BloggerController@manageArticle'));
	Route::any('sua-bai-viet/{id}',  array('before' => 'authnotlogin', 'uses' => 'App\Modules\Blogger\Controllers\BloggerController@editArticle'));
	Route::get('xoa-bai-viet/{id}',  array('before' => 'authnotlogin', 'uses' => 'App\Modules\Blogger\Controllers\BloggerController@deleteArticle'));
	Route::post('checktitleArticle',  array('as' => 'checktitleArticle', 'uses' => 'App\Modules\Blogger\Controllers\BloggerController@ajaxCheckTitle'));
	Route::any('doi-mat-khau.html',  array('as' => 'usr.resetpass', 'uses' => 'App\Modules\Blogger\Controllers\BloggerController@resetpass'));
});


