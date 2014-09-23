<?php

// Content routes
Route::get('/', array('as' =>'home',     'uses' => 'App\Modules\Content\Controllers\ContentController@getHome'));
Route::get('/gioi-thieu.html', array('as' =>'introduct',     'uses' => 'App\Modules\Content\Controllers\ContentController@introduction'));

// Custom 404 page
App::missing(function($exception)
{
    return Response::view('content::404', array(), 404);
});
