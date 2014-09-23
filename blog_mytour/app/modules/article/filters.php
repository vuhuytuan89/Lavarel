<?php
use App\Modules\Admin\Models\Users;
use App\Modules\Admin\Models\Article;
use App\Modules\Admin\Models\Category;
	//Filter check condition post article
	Route::filter('authpostnews', function()
	{
		if (!Session::has('infusr')) return Redirect::to('/login')->with('error', 'Bạn hãy đăng nhập để có thể đăng bài');
	});
	//Filter check condition show articles on the list check Mytour
	Route::filter('catCheckMytour', function($id)
	{
		$id_cat = $id->parameters()['id'];
		$checkCat = Category::getCatWhere(array('cat_id', 'cat_sub_id'), array('cat_is_approved' => 1, 'cat_id' => $id_cat, 'cat_check_mytour' => 1));
		if($checkCat){
			if (Session::has('infusr')){
				$checkUserMytour = Users::checkUserInMytour(Session::get('infusr_id'));
				$checkCatIT = Category::getCatWhere(array('cat_id', 'cat_sub_id'), array('cat_is_approved' => 1, 'cat_id' => $id_cat, 'cat_check_it' => 1));
				if(!$checkUserMytour){
					return Redirect::to('/');
				}elseif($checkCatIT){
					if($checkUserMytour[0]['department'] != 2){
						return Redirect::to('/');
					}
				}
			}else{
				return Redirect::to('/');
			}
		}
	});
	//Filter check condition show articles check Mytour
	Route::filter('articleCheckMytour', function($id)
	{
		$id_art = $id->parameters()['id'];
		$dataArticle = Article::getArtOne($id_art);
		$checkCat = Category::getCatWhere('cat_id', array('cat_is_approved' => 1, 'cat_id' => $dataArticle['art_cat_id'], 'cat_check_mytour' => 1));
		if($checkCat){
			if (Session::has('infusr')){
				$checkUserMytour = Users::checkUserInMytour(Session::get('infusr_id'));
				if(!$checkUserMytour){
					return Redirect::to('/');
				}
			}else{
				return Redirect::to('/');
			}
		}
	});
