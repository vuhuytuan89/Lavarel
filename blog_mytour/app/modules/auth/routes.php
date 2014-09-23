<?php
Route::group(array('before' => 'authlogin'), function(){
	Route::post('login',  array('as' =>'login.post',     'uses' => 'App\Modules\Auth\Controllers\AuthController@postlogin'));
	Route::get('login',  array('as' =>'login',     'uses' => 'App\Modules\Auth\Controllers\AuthController@getlogin'));
});
Route::get('logout',  array('as' =>'logout',     'uses' => 'App\Modules\Auth\Controllers\AuthController@getLogout'));
Route::post('checkusername',  array('as' =>'checkusername',     'uses' => 'App\Modules\Auth\Controllers\AuthController@ajaxcheckusername'));
Route::post('checkfield',  array('as' =>'checkfield',     'uses' => 'App\Modules\Auth\Controllers\AuthController@ajaxcheckfield'));
Route::post('checkfieldprofile',  array('as' =>'checkfieldProfile',     'uses' => 'App\Modules\Auth\Controllers\AuthController@ajaxcheckfieldProfile'));
Route::post('checkpass',  array('as' =>'checkpass',     'uses' => 'App\Modules\Auth\Controllers\AuthController@ajaxpasslogin'));

Route::post('/remindpass',  array('as' => 'remindpass.post',     'uses' => 'App\Modules\Auth\Controllers\RemindersController@postRemind'));
Route::get('/remindpass',  array('as' => 'remindpass',     'uses' => 'App\Modules\Auth\Controllers\RemindersController@getRemind'));

Route::post('/resetpass',  array('as' => 'resetpass.post',     'uses' => 'App\Modules\Auth\Controllers\RemindersController@postReset'));
Route::get('/resetpass/{token}',  array('as' => 'resetpass',     'uses' => 'App\Modules\Auth\Controllers\RemindersController@getReset'));
