<?php namespace App\Modules\Blogger\Controllers;

use Input, Redirect, View, Auth, Session, Str, Hash;
use App\Modules\Admin\Models\Article;
use App\Modules\Admin\Models\Comment;
use App\Modules\Admin\Models\Notify;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\Madmin;
use App\Modules\Auth\Models\AuthCustomer;
use App\Modules\Auth\Controllers\AuthController;
use App\Modules\Admin\Models\Users;

class BloggerController extends \BaseController
{
	public function homepage($username){
		$dataUser = AuthCustomer::getUserWhere('*', array('signature' => $username));
		if(!empty($dataUser)){
			if(Session::get('infusr_id')){
				$checkUserMytour = Users::checkUserInMytour(Session::get('infusr_id');
				if($checUserMytour){
					if($checUserMytour[0]['department'] == 2){
							$data = Article::getArtWhereJoin(array('article.*', 'users.avatar', 'users.id', 'users.signature', 'users.username', 'category.cat_name', 'category.cat_id'), array('article.art_is_approved' => 1), 'art_date_created', 'desc', 5);
					}else{
						$data = Article::getArtWhereJoin(array('article.*', 'users.avatar', 'users.id', 'users.signature', 'users.username', 'category.cat_name', 'category.cat_id'), array('article.art_is_approved' => 1, 'category.cat_check_it' => 0), 'art_date_created', 'desc', 5);
					}
			}else{
				$data = Article::getArtWhereJoin(array('article.*', 'users.id', 'users.username', 'users.signature', 'users.avatar', 'category.cat_name', 'category.cat_id'), array('article.art_is_approved' => 1, 'art_usr_id' => $dataUser[0]['id'], 'category.cat_check_mytour' => 0), 'art_date_created', 'desc', 5);
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
			$dataUser[0]['count_article'] = Article::getArtWhereCount(array('art_id'), array('art_usr_id' => $dataUser[0]['id'], 'art_is_approved' => 1));
			return View::make('blogger::homepage', array('article_paging' => $data, 'nameCat' => $dataUser[0]['username'], 'article' => $dataArticle, 'dataUser' => $dataUser));
		}else{
			return Redirect::to('/');
		}
	}

	public function get_profile(){
		$id_usr = Session::get('infusr_id');
		$dataUser = Users::getUserOne($id_usr);
		$breadcrumb[]['name'] = 'Cập nhật Profile';
		return View::make('blogger::profile', array('dataUser' => $dataUser, 'breadcrumb' => $breadcrumb));
	}

	public function post_profile(){
		$id_usr = Session::get('infusr_id');
		$dataUser = Users::getUserOne($id_usr);
		$dataIns = Input::only('signature', 'fullname', 'email', 'datebirth', 'placement', 'summary');
		if (Input::hasFile('avatar')) {
				if (Input::file('avatar')->isValid()) {
					$path = getcwd() . '/upload/users/';
					$filename = Input::file('avatar')->getClientOriginalName();
					$filename = time() . Madmin::convert_vi_to_en($filename);
				}
			} else {
				$filename = $dataUser['avatar'];
			}
			$dataIns['avatar'] = $filename;
			$dataIns['datebirth'] = Input::get('datebirth');
			if($dataIns['datebirth'] != null){
				$dataIns['datebirth'] = strtotime($dataIns['datebirth']);
			}
			$dataIns['updated_at'] = time();
			$result = Users::updateUser($dataIns, array('id' => $id_usr));
			if($result){
				if(Input::hasFile('avatar')){
					if($dataUser['avatar'] != 'no_avatar.jpg'){
						$pathUnLink = getcwd().'/upload/users/'.$dataUser['avatar'];;
						if(is_file($pathUnLink)){
							unlink($pathUnLink);
						}
						Input::file('avatar')->move($path, $filename);
					}
				}
				return Redirect::to('blogger/sua-profile.html')->with('success', 'Bạn đã cập nhật thành công');
			}
	}

	public function manageArticle(){
		$id_usr = Session::get('infusr_id');
		$dataPaging = Article::getArtWhereJoin(array('article.*', 'users.avatar', 'users.id', 'users.fullname', 'users.username', 'category.cat_name', 'category.cat_id'), array('art_usr_id' => $id_usr), 'art_date_created', 'desc', 5);
		$dataArticle = $dataPaging->toArray();
		$breadcrumb[]['name'] = 'Quản lý bài viết';
		return View::make('blogger::manageArticle', array('dataArticle' => $dataArticle['data'], 'dataPaging' => $dataPaging, 'breadcrumb' => $breadcrumb));
	}

	public function editArticle($id){
		$data['dataArticle'] = Article::getArtOne($id);
		$checkUser = Users::checkUserInMytour(Session::get('infusr_id'));
		if($checkUser){
			$data['dataCatParent'] = Category::getCatWhere(array('cat_id', 'cat_sub_id','cat_name'), array('cat_sub_id' => 0));
		}else{
			$data['dataCatParent'] = Category::getCatWhere(array('cat_id', 'cat_sub_id','cat_name'), array('cat_sub_id' => 0, 'cat_check_mytour' => 0));
		}
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
				return Redirect::to('/blogger/quan-ly-bai-viet.html');
			}
		}
		$data['breadcrumb'][]['name'] = 'Sửa bài viết';
		return View::make('blogger::editArticle', $data);
	}

	public function deleteArticle($id){
		$id = explode(",", $id);
		$dataArt = Article::getArtWhereIn(array('art_id'), 'art_id', $id);
		$result = Article::deleteArtWhereIn('art_id', $id);
		if($result){
			//delete Comment of User
			$rsCom = Comment::deleteComWhere('com_art_id', $id);
			//delete Notify of User
			$rsNotify = Notify::deleteNotifyWhere('not_art_id', $id);
			return Redirect::to('blogger/quan-ly-bai-viet.html');
		}
	}

	public function resetpass(){
		$dataUser = Users::getUserOne(Session::get('infusr_id'));
		if($_POST){
			$dataIns['password'] = Hash::make(Input::get('password_new'));
			$result = Users::updateUser($dataIns, array('id' => Session::get('infusr_id')));
			if($result){
				AuthController::getLogout();
				return Redirect::to('/login')->with('success', 'Bạn đã thay đổi mật khẩu thành công. Mời bạn hãy đăng nhập lại');
			}
			else{
				return View::make('blogger::resetpass', array('username' => $dataUser['username']))->with('error', 'Lỗi, bạn hãy thử lại');
			}
		}
		$breadcrumb[]['name'] = 'Đổi mật khẩu';
		return View::make('blogger::resetpass', array('username' => $dataUser['username'], 'breadcrumb' => $breadcrumb));
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