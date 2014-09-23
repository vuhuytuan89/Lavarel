<?php namespace App\Modules\Notify\Controllers;

use Input, Redirect, View, Auth, Session, Str;
use App\Modules\Admin\Models\Notify;
use App\Modules\Auth\Models\AuthCustomer;

class NotifyController extends \BaseController
{

	public function loadAllNotify(){
		$id_usr = Session::get('infusr_id');
		$data = Notify::getNotifyWherePaging(array('notify.*', 'comment.com_usr_id', 'comment.com_detail', 'comment.com_date_created', 'article.art_title'), array('not_usr_id' => $id_usr), 'not_id', 'desc');
		$dataNotify = $data->toArray();
		if($dataNotify['data']){
			$i = 0;
			foreach($dataNotify['data'] as $notify){
				$dataNotify['data'][$i]['date_created'] = $this->calculateTime($notify['com_date_created']);
				$dataUser = AuthCustomer::getUserWhere(array('id', 'username', 'signature', 'avatar'), array('id' => $notify['com_usr_id']));
				if($dataUser){
					$dataNotify['data'][$i]['avatar'] = $dataUser[0]['avatar'];
					$dataNotify['data'][$i]['username'] = $dataUser[0]['username'];
					$dataNotify['data'][$i]['signature'] = $dataUser[0]['signature'];
					$dataNotify['data'][$i]['user_id'] = $dataUser[0]['id'];
					$dataNotify['data'][$i]['art_seo_title'] = Str::slug($notify['art_title']);
					$i++;
				}
				else{
					$dataNotify['data'][$i]['avatar'] = '';
					$dataNotify['data'][$i]['username'] = '';
					$dataNotify['data'][$i]['signature'] = '';
					$dataNotify['data'][$i]['user_id'] = '';
					$dataNotify['data'][$i]['art_seo_title'] = '';
					$i++;
				}
			}
		}
		return View::make('notify::loadall', array('dataNotify' => $dataNotify['data'], 'dataPaging' => $data, 'nameCat' => 'Thông báo'));
	}

	public function ajaxUpdatenotify(){
		$id_user = Session::get('infusr_id');
		$dataNotify = array('not_is_approved' => 1);
		$result = Notify::updateNotify($dataNotify, array('not_is_approved' => 0, 'not_usr_id' => $id_user));
		return $result;
	}
}