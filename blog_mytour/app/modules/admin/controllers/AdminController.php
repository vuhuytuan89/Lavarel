<?php namespace App\Modules\Admin\Controllers;

use Admin, Auth, Input, Redirect, View, Hash, URL, Config;
use App\Modules\Admin\Models\Madmin;
use App\Modules\Admin\Models\Users;
use App\Modules\Admin\Models\Article;
use App\Modules\Admin\Models\Comment;
use App\Modules\Admin\Models\Notify;

class AdminController extends \BaseController{
	public function HomePage(){
		return View::make('admin::index')->with('name', 'Xin chào '.Auth::user()->username);
	}

	public function index(){
		$data = Users::getUserWherePaging('*', array('level' => 1), 'created_at', 'desc', 10);
		$dataAdmin = $data->toArray();
		return View::make('admin::admin.index', array('dataPaging' => $data, 'dataAdmin' => $dataAdmin['data']));
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
			$dataIns = Input::only('username', 'fullname', 'signature', 'email', 'department', 'placement', 'summary', 'is_approved');
			$dataIns['password'] = Hash::make(Input::get('password'));
			$dataIns['avatar'] = $filename;
			$dataIns['level'] = 1;
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
				return Redirect::route('admin.index');
			}

		}
		return View::make('admin::admin.add', array('departments' => $departments));
	}

	public function edit($id){
		$data = Users::getUserOne($id);
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
				$filename = $data['avatar'];
			}
			$dataIns = Input::only('username', 'fullname', 'signature', 'email', 'department', 'placement', 'summary');
			$dataIns['avatar'] = $filename;
			$dataIns['level'] = 1;
			$dataIns['datebirth'] = Input::get('datebirth');
			if($dataIns['datebirth'] != null){
				$dataIns['datebirth'] = strtotime($dataIns['datebirth']);
			}
			$dataIns['updated_at'] = time();
			$result = Users::updateUser($dataIns, array('id' => $id));
			if($result){
				if(Input::hasFile('avatar')){
					if($data['avatar'] != 'no_avatar.jpg'){
						$pathUnLink = getcwd().'/upload/users/'.$data['avatar'];;
						if(is_file($pathUnLink)){
							unlink($pathUnLink);
						}
						Input::file('avatar')->move($path, $filename);
					}
				}
				return Redirect::route('admin.index');
			}
		}
		return View::make('admin::admin.edit', array('dataAdmin' => $data, 'departments' => $departments));
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
			return Redirect::route('admin.index');
		}
	}

	public function changePassAdmin(){
		if($_POST){
			$dataIns['password'] = Hash::make(Input::get('password_new'));
			$result = Users::updateUser($dataIns, array('id' => Auth::id()));
			if($result){
				return Redirect::route('admin.changepass')->with('success', 'Bạn đã thay đổi mật khẩu thành công');
			}
			else{
				return Redirect::route('admin.changepass')->with('error', 'Lỗi, bạn hãy thử lại');
			}
		}
		return View::make('admin::admin.changepass');
	}

	public function active(){
		$url = URL::to('/');
		$id = Input::get('id');
		$ih = Input::get('ih');
		$hot = Input::get('hot');
		$colwhere = Input::get('iw');
		$html = '';
		if($ih == 1){
			$ih = 0;
		}
		elseif($ih == 0){
			$ih = 1;
		}
		$data = Madmin::changeCol(Input::get('tbl'), Input::get('col'), $ih, array($colwhere => $id));
		if($data){
			$html = '<img src="'.$url.'/backend/assets/images/'.$ih.'.png">';
			$html .= '<input type="hidden" id="'.Input::get('col').$hot.'" value="'.$ih.'">';
		}
		echo $html;
	}

	/**
	 * Display login screen
	 * @return View
	 */
	public function getLogin()
	{
		return View::make('admin::auth.login');
	}

	/**
	 * Login action
	 * @return Redirect
	 */
	public function postLogin()
	{
		$credentials = array(
			'username' => Input::get('username'),
			'password' => Input::get('password'),
			'level' => 1,
			'is_approved' => 1
		);

		try
		{
			$user = Auth::attempt($credentials, true);

			if ($user)
			{
				return Redirect::route('admin');
			}
			else{
				return View::make('admin::auth.login');
			}
		}
		catch(\Exception $e)
		{
			return Redirect::route('admin.login')->withErrors(array('login' => $e->getMessage()));
		}
	}

	public function ajaxusernamelogin()
	{
		$username = Input::get('username');
		$check = Madmin::getCountUser(array('level' => 1, 'username' => $username));
		if($check){
			return 1;
		}
		else{
			return 0;
		}
	}

	public function ajaxusernameedit()
	{
		$id_usr = Input::get('id');
		$username = Input::get('username');
		$check = Madmin::getCountUser(array('username' => $username));
		if($check){
			$check_id = Madmin::getCountUser(array('username' => $username, 'id' => $id_usr));
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

	public function ajaxCheckEmail()
	{
		$email = Input::get('email');
		$check = Madmin::getCountUser(array('level' => 1, 'email' => $email));
		if($check){
			return 1;
		}
		else{
			return 0;
		}
	}

	public function ajaxcheckfieldEditLogin()
	{
		$id_usr = Input::get('id');
		$field = Input::get('field');
		$value = Input::get('value');
		$check = Madmin::getCountUser(array("$field" => $value));
		if($check){
			$check_id = Madmin::getCountUser(array("$field" => $value, 'id' => $id_usr));
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

	public function ajaxpasslogin()
	{
		$username = Input::get('username');
		$pass = Input::get('password');
		$hashedPassword = Madmin::getUser($username);
		if($hashedPassword){
			if (Hash::check($pass, $hashedPassword[0]['password']))
			{
				return 1;
			}
			else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}

	/**
	 * Logout action
	 * @return Redirect
	 */
	public function getLogout()
	{
		Auth::logout();

		return Redirect::route('admin.login');
	}

}
