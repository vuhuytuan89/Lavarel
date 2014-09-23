<?php namespace App\Modules\Article\Controllers;

use Input, Redirect, View, Auth, Session, Str;
use App\Modules\Admin\Models\Article;
use App\Modules\Admin\Models\Comment;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\Users;

class ArticleController extends \BaseController
{
	public function allNewArticle(){
		$id_usr = Session::get('infusr_id');
		$checUserMytour = Users::checkUserInMytour($id_usr);
		if($checUserMytour){
			if($checUserMytour[0]['department'] == 2){
				$data = Article::getArtWhereJoin(array('article.*', 'users.avatar', 'users.id', 'users.signature', 'users.username', 'category.cat_name', 'category.cat_id'), array('article.art_is_approved' => 1), 'art_date_created', 'desc', 5);
			}else{
				$data = Article::getArtWhereJoin(array('article.*', 'users.avatar', 'users.id', 'users.signature', 'users.username', 'category.cat_name', 'category.cat_id'), array('article.art_is_approved' => 1, 'category.cat_check_it' => 0), 'art_date_created', 'desc', 5);
			}
		}else{
			$data = Article::getArtWhereJoin(array('article.*', 'users.avatar', 'users.id', 'users.signature', 'users.username', 'category.cat_name', 'category.cat_id'), array('article.art_is_approved' => 1, 'category.cat_check_mytour' => 0), 'art_date_created', 'desc', 5);
		}
		$dataArticle = $data->toArray();
		if($dataArticle['data']){
			$i = 0;
			foreach($dataArticle['data'] as $art){
				$dataCom = Comment::getComWhereCount('com_id', array('com_art_id' => $art['art_id']));
				if($dataCom){
					$dataArticle['data'][$i]['count_com'] = $dataCom;
				}
				else{
					$dataArticle['data'][$i]['count_com'] = 0;
				}
				$dataArticle['data'][$i]['cat_seo_name'] = Str::slug($art['cat_name']);
				$dataArticle['data'][$i]['art_seo_title'] = Str::slug($art['art_title']);
				$i++;
			}
		}
		$breadcrumb[] = array('name' => 'Bài viết tổng hợp');
		View::share('article', $dataArticle);
		return View::make('article::allNewArticle', array('article_paging' => $data, 'title' => 'Bài viết mới nhất', 'breadcrumb' => $breadcrumb));

	}

	public function postArticle()
	{
		$checkUser = Users::checkUserInMytour(Session::get('infusr_id'));
		if($checkUser){
			if($checkUser['department'] == 2){
				$data['dataCatParent'] = Category::getCatWhere(array('cat_id', 'cat_sub_id','cat_name'), array('cat_sub_id' => 0));
			}else{
				$data['dataCatParent'] = Category::getCatWhere(array('cat_id', 'cat_sub_id','cat_name'), array('cat_sub_id' => 0, 'cat_check_it' => 0));
			}
		}else{
			$data['dataCatParent'] = Category::getCatWhere(array('cat_id', 'cat_sub_id','cat_name'), array('cat_sub_id' => 0, 'cat_check_mytour' => 0));
		}
		if($data['dataCatParent']){
			$i = 0;
			foreach($data['dataCatParent'] as $val){
				$dataCatChild = Category::getCatWhere(array('cat_id','cat_name'), array('cat_sub_id' => $val['cat_id']));
				if($dataCatChild){
					$data['dataCatParent'][$i]['dataCatChild'] = $dataCatChild;
				}
				$i++;
			}
		}

		if($_POST){
			$dataIns = Input::only('art_cat_id', 'art_title', 'art_shortdetail', 'art_detail', 'art_is_approved');
			$dataIns['art_usr_id'] = Session::get('infusr_id');
			$dataIns['art_date_created'] = time();
			$dataIns['art_is_approved'] = 1;
			$result = Article::addArt($dataIns);
			if($result){
				return Redirect::to('/');
			}

		}
		$data['breadcrumb'][] = array('name' => 'Đăng bài mới');
		return View::make('article::postArticle', $data);
	}

	public function catArticle($id){
		$dataCatSeo = Category::getCatOne($id);
		$id_usr = Session::get('infusr_id');
		if($id_usr){
			$checkUserMytour = Users::checkUserInMytour($id_usr);
			if($checkUserMytour){
				if($checkUserMytour[0]['department'] == 2){
					$dataCat = Category::getCatSubQuery(array('category.cat_sub_id' => $id));
				}else{
					$dataCat = Category::getCatSubQuery(array('category.cat_sub_id' => $id, 'category.cat_check_it' => 0));
				}
			}
		}else{
			$dataCat = Category::getCatSubQuery(array('category.cat_sub_id' => $id, 'category.cat_check_mytour' => 0));
		}
		$idCat = array($id);
		if($dataCatSeo['cat_sub_id'] == 0){
			$breadcrumb[0]['id'] = $dataCatSeo['cat_id'];
			$breadcrumb[0]['name'] = $dataCatSeo['cat_name'];
			$breadcrumb[0]['seo_name'] = Str::slug($dataCatSeo['cat_name']);
		}else{
			$dataCatParent = Category::getCatOne($dataCatSeo['cat_sub_id']);
			$breadcrumb[0]['id'] = $dataCatParent['cat_id'];
			$breadcrumb[0]['name'] = $dataCatParent['cat_name'];
			$breadcrumb[0]['seo_name'] = Str::slug($dataCatParent['cat_name']);
			$breadcrumb[1]['id'] = $dataCatSeo['cat_id'];
			$breadcrumb[1]['name'] = $dataCatSeo['cat_name'];
			$breadcrumb[1]['seo_name'] = Str::slug($dataCatSeo['cat_name']);
		}
		if($dataCat){
			$i = 0;
			foreach($dataCat as $cat){
				$idCat[] = $cat['cat_id'];
				$i++;
			}
		}
		$data = Article::getArtWhereInJoin(array('article.*', 'users.avatar', 'users.id', 'users.signature', 'users.username', 'category.cat_name', 'category.cat_id'), array('article.art_is_approved' => 1), $idCat, 'art_date_created', 'desc', 5);
		$dataArticle = $data->toArray();
		if($dataArticle['data']){
			$i = 0;
			foreach($dataArticle['data'] as $art){
				$dataCom = Comment::getComWhereCount('com_id', array('com_art_id' => $art['art_id']));
				if($dataCom){
					$dataArticle['data'][$i]['count_com'] = $dataCom;
				}
				else{
					$dataArticle['data'][$i]['count_com'] = 0;
				}
				$dataArticle['data'][$i]['cat_seo_name'] = Str::slug($art['cat_name']);
				$dataArticle['data'][$i]['art_seo_title'] = Str::slug($art['art_title']);
				$i++;
			}
		}
		$dataComSlide = Comment::getComWhereGroup(array('art_is_approved' => 1), $idCat);
		if($dataComSlide){
			$i = 0;
			foreach($dataComSlide as $slide){
				$dataComSlide[$i]->art_seo_title = Str::slug($slide->art_title);
				$i++;
			}
		}
		View::share('article', $dataArticle);
		return View::make('article::catarticle', array('article_paging' => $data, 'title' => $dataCatSeo['cat_name'], 'dataSlide' => $dataComSlide, 'breadcrumb' => $breadcrumb));
	}

	public function detailArticle($id){
		$dataArticle = Article::getArtOne($id);
		if($dataArticle){
			$dataCat = Category::getCatOne($dataArticle['art_cat_id']);
			if($dataCat['cat_sub_id'] == 0){
				$breadcrumb[0]['id'] = $dataCat['cat_id'];
				$breadcrumb[0]['name'] = $dataCat['cat_name'];
				$breadcrumb[0]['seo_name'] = Str::slug($dataCat['cat_name']);
				$breadcrumb[1]['id'] = $dataArticle['art_id'];
				$breadcrumb[1]['name'] = str_limit($dataArticle['art_title'], $limit = 25, $end = '...');
				$breadcrumb[1]['seo_name'] = Str::slug($dataArticle['art_title']);
			}else{
				$dataCatParent = Category::getCatOne($dataCat['cat_sub_id']);
				$breadcrumb[0]['id'] = $dataCatParent['cat_id'];
				$breadcrumb[0]['name'] = $dataCatParent['cat_name'];
				$breadcrumb[0]['seo_name'] = Str::slug($dataCatParent['cat_name']);
				$breadcrumb[1]['id'] = $dataCat['cat_id'];
				$breadcrumb[1]['name'] = $dataCat['cat_name'];
				$breadcrumb[1]['seo_name'] = Str::slug($dataCat['cat_name']);
				$breadcrumb[2]['name'] = str_limit($dataArticle['art_title'], $limit = 25, $end = '...');
			}
			return View::make('article::detail', array('dataArticle' => $dataArticle, 'title' => $dataArticle['art_title'], 'breadcrumb' => $breadcrumb));
		}else{
			return Redirect::to('/');
		}
	}

	public function search(){
		if (Input::has('key_search'))
		{
			$value = Input::get('key_search');
			Session::put('key_search', $value);
		}
		elseif(!Input::has('page')){
			Session::forget('key_search');
		}
		$key = Session::get('key_search');
		$id_usr = Session::get('infusr_id');
		$checUserMytour = Users::checkUserInMytour($id_usr);
		if($checUserMytour){
			$data = Article::getArtWhereLikeJoin(array('article.*', 'users.avatar', 'users.id', 'users.signature', 'users.username', 'category.cat_name', 'category.cat_id'), $key, array('article.art_is_approved' => 1),'art_date_created', 'desc', 3);
		}else{
			$data = Article::getArtWhereLikeJoin(array('article.*', 'users.avatar', 'users.id', 'users.signature', 'users.username', 'category.cat_name', 'category.cat_id'), $key, array('article.art_is_approved' => 1, 'category.cat_check_mytour' => 0), 'art_date_created', 'desc', 3);
		}
		$count_result = count($data->get());
		$data = $data->paginate(5);
		$dataArticle = $data->toArray();
		if($dataArticle['data']){
			$i = 0;
			foreach($dataArticle['data'] as $art){
				$dataCom = Comment::getComWhereCount('com_id', array('com_art_id' => $art['art_id']));
				if($dataCom){
					$dataArticle['data'][$i]['count_com'] = $dataCom;
				}
				else{
					$dataArticle['data'][$i]['count_com'] = 0;
				}
				$dataArticle['data'][$i]['cat_seo_name'] = Str::slug($art['cat_name']);
				$dataArticle['data'][$i]['art_seo_title'] = Str::slug($art['art_title']);
				$i++;
			}
		}
		$breadcrumb[]['name'] = 'Tìm kiếm';
		return View::make('article::search', array('key' => $key, 'count_result' => $count_result, 'dataPaging' => $data, 'dataSearch' => $dataArticle['data'], 'breadcrumb' => $breadcrumb));
	}

	public function ajaxchecktitle(){
		$title = Input::only('title');
		$check = Article::getArtWhereCount('art_id', array('art_title' => $title['title']));
		return $check;
	}
}