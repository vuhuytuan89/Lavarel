<?php namespace App\Modules\Admin\Controllers;

use Input, Redirect, View, Auth;
use App\Modules\Admin\Models\Article;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\Madmin;
use App\Modules\Admin\Models\Comment;
use App\Modules\Admin\Models\Notify;

class ArticleController extends \BaseController
{

	public function index()
	{
		$data = Article::getArtAllJoin();
		$dataArt = $data->toArray();
		return View::make('admin::article.index', array('dataArt' => $dataArt['data'], 'dataPaging' => $data));
	}

	public function add(){
		$data['dataCatParent'] = Category::getCatWhere(array('cat_id', 'cat_sub_id','cat_name'), array('cat_sub_id' => 0));
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
//		echo '<pre>';
//		print_r($data);
//		echo '</pre>';die;

		if($_POST){
			$dataIns = Input::only('art_cat_id', 'art_title', 'art_shortdetail', 'art_detail', 'art_is_approved');
			$dataIns['art_usr_id'] = Auth::Id();
			$dataIns['art_date_created'] = time();
			$result = Article::addArt($dataIns);
			if($result){
				return Redirect::route('art.article');
			}

		}
		return View::make('admin::article.add', $data);
	}

	public function edit($id){
		$data['dataArt'] = Article::getArtOne($id);
		$data['dataCatParent'] = Category::getCatWhere(array('cat_id', 'cat_name', 'cat_sub_id'), array('cat_sub_id' => 0));
		if($data['dataCatParent']){
			$i = 0;
			foreach($data['dataCatParent'] as $val){
				$dataCatChild = Category::getCatWhere(array('cat_id','cat_name', 'cat_sub_id'), array('cat_sub_id' => $val['cat_id']));
				if($dataCatChild){
					$data['dataCatParent'][$i]['dataCatChild'] = $dataCatChild;
				}
				$i++;
			}
		}

		if($_POST){
			$dataIns = Input::only('art_cat_id', 'art_title', 'art_shortdetail', 'art_detail', 'art_is_approved');
			$result = Article::updateArt($dataIns, array('art_id' => $id));
			if($result){
				return Redirect::route('art.article');
			}
		}
		return View::make('admin::article.edit', $data);
	}

	public function delete($id){
		$id = explode(",", $id);
		$dataArt = Article::getArtWhereIn(array('art_id'), 'art_id', $id);
		$result = Article::deleteArtWhereIn('art_id', $id);
		//delete Comment of User
		$rsCom = Comment::deleteComWhere('com_art_id', $id);
		//delete Notify of User
		$rsNotify = Notify::deleteNotifyWhere('not_art_id', $id);
		return Redirect::route('art.article');
	}

	public function ajaxCheckTitle(){
		$id = Input::get('id');
		$title = Input::get('title');
		$check = Article::getArtWhereCount('art_id', array('art_title' => $title));
		if($check){
			$check_id = Article::getArtWhereCount('art_id', array('art_title' => $title, 'art_id' => $id));
			if($check_id){
				return 0;
			}
			else{
				return 1;
			}
		}
		else{
			return 0;
		}
	}
}