<?php namespace App\Modules\Admin\Controllers;

use Input, Redirect, View, Auth, Hash, Config;
use App\Modules\Admin\Models\Users;
use App\Modules\Admin\Models\Madmin;
use App\Modules\Admin\Models\Article;
use App\Modules\Admin\Models\Comment;
use App\Modules\Admin\Models\Notify;

class UsersController extends \BaseController
{

	public function index()
	{
		$data = Users::getUserWherePaging('*', array('level' => 2), 'created_at', 'desc', 10);
		$dataUser = $data->toArray();
		return View::make('admin::users.index', array('dataUser' => $dataUser['data'], 'dataPaging' => $data));
	}

	public function add(){
		$departments = Config::get('configuration');
		$departments = $departments['department'];
		if($_POST){
			if(Input::hasFile('avatar')){
				if(Input::file('avatar')->isValid()){
					$path = getcwd().'/upload/users/';
					$filename = Input::file('avatar')->getClientOriginalName();
					$filename = time().Madmin::convert_vi_to_en($filename);
				}
			}else{
				$filename = 'no_avatar.jpg';
			}
			$dataIns = Input::only('username', 'fullname', 'signature', 'email', 'department', 'placement', 'summary', 'check_mytour', 'is_approved');
			$dataIns['password'] = Hash::make(Input::get('password'));
			$dataIns['avatar'] = $filename;
			$dataIns['level'] = 2;
			$dataIns['datebirth'] = Input::get('datebirth');
			if($dataIns['datebirth'] != null){
				$dataIns['datebirth'] = strtotime($dataIns['datebirth']);
			}
			$dataIns['created_at'] = $dataIns['updated_at'] = time();
			$result = Users::addUser($dataIns);
			if($result){
				if(Input::hasFile('avatar')){
					Input::file('avatar')->move($path, $filename);
				}
				return Redirect::route('usr.user');
			}

		}
		return View::make('admin::users.add', array('departments' => $departments));
	}

	public function edit($id){
		$departments = Config::get('configuration');
		$data['departments'] = $departments['department'];
		$data['dataUser'] = Users::getUserOne($id);
		if($_POST){
			if(Input::hasFile('avatar')){
				if(Input::file('avatar')->isValid()){
					$path = getcwd().'/upload/users/';
					$filename = Input::file('avatar')->getClientOriginalName();
					$filename = time().Madmin::convert_vi_to_en($filename);
				}
			}else{
				$filename = $data['dataUser']['avatar'];
			}
			$dataIns = Input::only('username', 'fullname', 'signature', 'email', 'department', 'placement', 'summary', 'check_mytour', 'is_approved');
			$dataIns['avatar'] = $filename;
			$dataIns['level'] = 2;
			$dataIns['datebirth'] = Input::get('datebirth');
			if($dataIns['datebirth'] != null){
				$dataIns['datebirth'] = strtotime($dataIns['datebirth']);
			}
			$dataIns['updated_at'] = time();
			$result = Users::updateUser($dataIns, array('id' => $id));
			if($result){
				if(Input::hasFile('avatar')){
					if($data['dataUser']['avatar'] != 'no_avatar.jpg'){
						$pathUnLink = getcwd().'/upload/users/'.$data['dataUser']['avatar'];;
						if(is_file($pathUnLink)){
							unlink($pathUnLink);
						}
						Input::file('avatar')->move($path, $filename);
					}
				}
				return Redirect::route('usr.user');
			}
		}
		return View::make('admin::users.edit', $data);
	}

	public function delete($id){
		$id = explode(",", $id);
		$result = Users::deleteUser($id);
		$result = 1;
		if($result){
			//delete Article of User
			$dataArticle = Article::getArtWhereIn(array('art_id'), 'art_usr_id', $id);
			$rsArt = Article::deleteArtWhereIn('art_usr_id', $id);
			//delete Comment of User
			$rsCom = Comment::deleteComWhere('com_usr_id', $id);
			//delete Notify of User
			$rsNotify = Notify::deleteNotifyWhere('not_usr_id', $id);
			return Redirect::route('usr.user');
		}
	}

	public function changePass($id){
		$dataUser = Users::getUserWhere('username', array('id' => $id));
		if($_POST){
			$dataIns['password'] = Hash::make(Input::get('password_new'));
			$result = Users::updateUser($dataIns, array('id' => $id));
			if($result){
				return Redirect::to('/admin/user')->with('success', 'Bạn đã thay đổi mật khẩu thành công');
			}
			else{
				return View::make('admin::users.changepass')->with('error', 'Lỗi, bạn hãy thử lại');
			}
		}
		return View::make('admin::users.changepass');
	}
}