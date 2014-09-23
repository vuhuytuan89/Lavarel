<?php
	Route::filter('authcomment', function()
	{
		if (!Session::has('infusr')) return Redirect::to('/login')->with('error', 'Bạn hãy đăng nhập để có thể bình luận');
	});
