<?php namespace App\Modules\Auth\Controllers;

use Auth, Input, Redirect, View, Hash, Session, Str;
use App\Modules\Admin\Models\Madmin;
use App\Modules\Auth\Models\AuthCustomer;

/**
 * Authentication controller
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class AuthController extends \BaseController
{

	/**
	 * Display login screen
	 * @return View
	 */
	public function getLogin()
	{
		return View::make('auth::login', array('login' => 1));
	}

	/**
	 * Attempt to login
	 * @return Redirect
	 */
	public function postLogin()
	{
		$Input = array(
			'username'     => Input::get('username'),
			'password' => Input::get('password'),
		);
		$dataUser = AuthCustomer::getUserWhere(array('id', 'username', 'signature'), array('username' => $Input['username']));
		Session::put('infusr', $Input['username']);
		Session::put('infusr_id', $dataUser[0]['id']);
		Session::put('infusr_signature', $dataUser[0]['signature']);
		return Redirect::intended('/');
	}

	/**
	 * Log a user out
	 * @return Redirect
	 */
	public static function getLogout()
	{
		Session::forget('infusr');
		Session::forget('infusr_id');
		return Redirect::to('/');
	}

	public function ajaxcheckusername()
	{
		$username = Input::get('username');
		$check = Madmin::getCountUser(array('username' => $username));
		if($check){
			return 1;
		}
		else{
			return 0;
		}
	}

	public function ajaxcheckfield()
	{
		$field = Input::get('field');
		$value = Input::get('value');
		$check = Madmin::getCountUser(array("$field" => $value));
		if($check){
			return 1;
		}
		else{
			return 0;
		}
	}

	public function ajaxcheckfieldProfile()
	{
		$id_usr = Session::get('infusr_id');
		$field = Input::get("field");
		$value = Input::get("value");
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
}
