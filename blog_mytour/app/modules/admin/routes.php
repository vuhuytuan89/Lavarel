<?php

Route::post('admin/login', array('as' => 'admin.login.post', 'uses' => 'App\Modules\Admin\Controllers\AdminController@postLogin'));
Route::post('admin/ajaxusername', array('as' => 'admin.ajaxusernamelogin', 'uses' => 'App\Modules\Admin\Controllers\AdminController@ajaxusernamelogin'));
Route::post('admin/ajaxusernameedit', array('as' => 'admin.checkusernameEdit', 'uses' => 'App\Modules\Admin\Controllers\AdminController@ajaxusernameedit'));
Route::post('admin/ajaxemail', array('as' => 'admin.CheckEmail', 'uses' => 'App\Modules\Admin\Controllers\AdminController@ajaxCheckEmail'));
Route::post('admin/checkemaillogin', array('as' => 'admin.checkfieldEditLogin', 'uses' => 'App\Modules\Admin\Controllers\AdminController@ajaxcheckfieldEditLogin'));
Route::post('admin/ajaxchecktitle', array('as' => 'admin.checktitle', 'uses' => 'App\Modules\Admin\Controllers\ArticleController@ajaxCheckTitle'));
Route::post('admin/ajaxpass', array('as' => 'admin.ajaxpasslogin', 'uses' => 'App\Modules\Admin\Controllers\AdminController@ajaxpasslogin'));
Route::get('admin/login', array('as' => 'admin.login', 'uses' => 'App\Modules\Admin\Controllers\AdminController@getLogin'))->before('adminguest');

Route::any('admin/changepass',  array('as' => 'admin.changepass',     'uses' => 'App\Modules\Admin\Controllers\AdminController@changePassAdmin'));
Route::post('admin/remindpassword',  array('as' => 'usr.remind.post',     'uses' => 'App\Modules\Admin\Controllers\RemindersController@postRemind'));
Route::get('admin/remindpassword',  array('as' => 'usr.remind',     'uses' => 'App\Modules\Admin\Controllers\RemindersController@getRemind'));
Route::post('admin/resetpassword',  array('as' => 'usr.reset.post',     'uses' => 'App\Modules\Admin\Controllers\RemindersController@postReset'));
Route::get('admin/resetpassword/{token}',  array('as' => 'usr.reset',     'uses' => 'App\Modules\Admin\Controllers\RemindersController@getReset'));

Route::group(array('prefix' => 'admin', 'before' => 'authadmin'), function(){
	Route::get('logout', array('as' => 'admin.logout', 'uses' => 'App\Modules\Admin\Controllers\AdminController@getLogout'));

	//route admin
	Route::get('/', array('as' => 'admin',     'uses' => 'App\Modules\Admin\Controllers\AdminController@HomePage'));
	Route::get('index', array('as' => 'admin.index',     'uses' => 'App\Modules\Admin\Controllers\AdminController@index'));
	Route::any('admadd', array('as' => 'admin.add',     'uses' => 'App\Modules\Admin\Controllers\AdminController@add'));
	Route::any('admedit/{id}', array('as' => 'admin.edit',     'uses' => 'App\Modules\Admin\Controllers\AdminController@edit'));
	Route::get('admdelete/{id}', array('as' => 'admin.delete',     'uses' => 'App\Modules\Admin\Controllers\AdminController@delete'));
	Route::get('active', array('as' => 'admin.active',     'uses' => 'App\Modules\Admin\Controllers\AdminController@active'));
	Route::get('activeCat', array('as' => 'cat.active',     'uses' => 'App\Modules\Admin\Controllers\CategoryController@active'));

	//route category
		Route::any('category/catadd',  array('as' => 'cat.add',     'uses' => 'App\Modules\Admin\Controllers\CategoryController@add'));
		Route::any('category/catedit/{id}',  array('as' => 'cat.edit',     'uses' => 'App\Modules\Admin\Controllers\CategoryController@edit'));
		Route::get('category/catdelete/{id}',  array('as' => 'cat.delete',     'uses' => 'App\Modules\Admin\Controllers\CategoryController@delete'));
		Route::get('category',  array('as' => 'cat.category',     'uses' => 'App\Modules\Admin\Controllers\CategoryController@index'));

	//route article
		Route::any('article/artadd',  array('as' => 'art.add',     'uses' => 'App\Modules\Admin\Controllers\ArticleController@add'));
		Route::any('article/artedit/{id}',  array('as' => 'art.edit',     'uses' => 'App\Modules\Admin\Controllers\ArticleController@edit'));
		Route::get('article/artdelete/{id}',  array('as' => 'art.delete',     'uses' => 'App\Modules\Admin\Controllers\ArticleController@delete'));
		Route::get('article',  array('as' => 'art.article',     'uses' => 'App\Modules\Admin\Controllers\ArticleController@index'));

	//route comment
		Route::any('comment/comadd',  array('as' => 'com.add',     'uses' => 'App\Modules\Admin\Controllers\CommentController@add'));
		Route::any('comment/comedit/{id}',  array('as' => 'com.edit',     'uses' => 'App\Modules\Admin\Controllers\CommentController@edit'));
		Route::get('comment/comdelete/{id}',  array('as' => 'com.delete',     'uses' => 'App\Modules\Admin\Controllers\CommentController@delete'));
		Route::get('comment',  array('as' => 'com.comment',     'uses' => 'App\Modules\Admin\Controllers\CommentController@index'));
		Route::get('comment/loadDatatable',  array('as' => 'com.comment.loaddatatable',     'uses' => 'App\Modules\Admin\Controllers\CommentController@loadDatatable'));

	//route users
		Route::any('user/usradd',  array('as' => 'usr.add',     'uses' => 'App\Modules\Admin\Controllers\UsersController@add'));
		Route::any('user/usredit/{id}',  array('as' => 'usr.edit',     'uses' => 'App\Modules\Admin\Controllers\UsersController@edit'));
		Route::get('user/usrdelete/{id}',  array('as' => 'usr.delete',     'uses' => 'App\Modules\Admin\Controllers\UsersController@delete'));
		Route::get('user',  array('as' => 'usr.user',     'uses' => 'App\Modules\Admin\Controllers\UsersController@index'));
		Route::any('user/thay-doi-mat-khau/{id}',  array('as' => 'usr.changepass',     'uses' => 'App\Modules\Admin\Controllers\UsersController@changePass'));
	});
