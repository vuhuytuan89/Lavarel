<?php
	Route::post('ajaxupdatenotify',  array('before' => 'authcomment', 'uses' => 'App\Modules\Notify\Controllers\NotifyController@ajaxupdatenotify'));
	Route::get('thong-bao.html',  array('before' => 'authcomment', 'uses' => 'App\Modules\Notify\Controllers\NotifyController@loadAllNotify'));
