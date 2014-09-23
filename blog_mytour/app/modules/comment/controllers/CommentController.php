<?php namespace App\Modules\Comment\Controllers;

use Input, Redirect, View, Auth, Session, Paginator;
use App\Modules\Admin\Models\Article;
use App\Modules\Admin\Models\Comment;
use App\Modules\Admin\Models\Notify;
use App\Modules\Auth\Models\AuthCustomer;
use App\Modules\Admin\Models\Users;

class CommentController extends \BaseController
{
	public function ajaxLoadComment(){
		if(Input::get('com_art_id') != null){
			$dataIns = Input::only('com_art_id', 'com_detail', 'com_quote_id');
			$com_detail = explode('</blockquote>', $dataIns['com_detail']);
			if(count($com_detail) > 1){
				$dataIns['com_detail'] = $com_detail[1];
			}
			$dataIns['com_date_created'] = time();
			$dataIns['com_is_approved'] = 1;
			$dataArticle = Article::getArtOne($dataIns['com_art_id']);
			$dataUser = AuthCustomer::getUserWhere(array('id', 'avatar'), array('id' => Input::get('id_usr')));
			$dataIns['com_usr_id'] = Input::get('id_usr');
			$result = Comment::addCom($dataIns);
			if($result){
				//add data notify
				if($dataIns['com_usr_id'] != $dataArticle['art_usr_id']){
					$dataNotify['not_usr_id'] = $dataArticle['art_usr_id'];
					$dataNotify['not_com_id'] = $result;
					$dataNotify['not_art_id'] = $dataIns['com_art_id'];
					$dataNotify['not_is_approved'] = 0;
					$dataNotify['not_type'] = 1;
					Notify::addNotify($dataNotify);
				}
				if($dataIns['com_quote_id'] != 0){
					$dataCom = Comment::getComOne($dataIns['com_quote_id']);
					$dataNotify1['not_usr_id'] = $dataCom['com_usr_id'];
					$dataNotify1['not_com_id'] = $result;
					$dataNotify1['not_art_id'] = $dataIns['com_art_id'];
					$dataNotify1['not_is_approved'] = 0;
					$dataNotify1['not_type'] = 2;
					Notify::addNotify($dataNotify1);
				}
				$dataIns['avatar'] = $dataUser[0]['avatar'];
				$dataIns['username'] = Input::get('username');
			}
		}
		if(Input::get('id_art') != null){
			$id_art = Input::get('id_art');
		}else{
			$id_art = $dataIns['com_art_id'];
		}
		$dataCommentAll = Comment::getComWhereCount('com_id', array('comment.com_art_id' => $id_art, 'comment.com_is_approved' => 1));
		if(Input::get('com_art_id') != null){
			Paginator::setCurrentPage(ceil($dataCommentAll/8));
		}
		$dataCommentPaging = Comment::getComAllJoinPaging(array('article.art_id' => $id_art, 'comment.com_is_approved' => 1), 8, 'com_date_created');
		$dataComment = $dataCommentPaging->toArray();

		$i = 0;
		foreach($dataComment['data'] as $com){
			if($com['com_quote_id'] != 0){
				$comdetail = Comment::getComOne($com['com_quote_id']);
				$blogger = Users::getUserOne($comdetail['com_usr_id']);
				$dataComment['data'][$i]['com_quote_detail'] = $comdetail['com_detail'];
				$dataComment['data'][$i]['blogger_quote'] = $blogger['username'];
			}
			$i++;
		}
		if(isset($result) && $result){
			$last_id_comment = $result;
		}else{
			$last_id_comment = 0;
		}
		return View::make('comment::ajaxLoadComment', array('dataComment' => $dataComment['data'], 'count_comment_all' => $dataCommentAll, 'dataPaging' => $dataCommentPaging, 'count_comment_all' => $dataCommentAll, 'id_art' => $id_art, 'last_id_comment' => $last_id_comment));
	}

	public function ajaxLoadPagingComment(){
		$id_art = Input::get('id_art');
		$dataCommentAll = Comment::getComWhereCount('com_id', array('comment.com_art_id' => $id_art, 'comment.com_is_approved' => 1));
		$dataCommentPaging = Comment::getComAllJoinPaging(array('article.art_id' => $id_art, 'comment.com_is_approved' => 1), 8, 'com_date_created');
		$dataComment = $dataCommentPaging->toArray();
		$i = 0;
		foreach($dataComment['data'] as $com){
			if($com['com_quote_id'] != 0){
				$comdetail = Comment::getComOne($com['com_quote_id']);
				$blogger = Users::getUserOne($comdetail['com_usr_id']);
				$dataComment['data'][$i]['com_quote_detail'] = $comdetail['com_detail'];
				$dataComment['data'][$i]['blogger_quote'] = $blogger['username'];
			}
			$i++;
		}
		return View::make('comment::ajax_load_paging_comment', array('dataComment' => $dataComment['data'], 'dataPaging' => $dataCommentPaging, 'count_comment_all' => $dataCommentAll, 'id_art' => $id_art));
	}

	public function ajaxUpdatenotify(){
		$id_user = Session::get('infusr_id');
		$dataNotify = array('not_is_approved' => 1);
		$result = Notify::updateNotify($dataNotify, array('not_is_approved' => 0, 'not_usr_id' => $id_user));
		return $result;
	}
}