<?php namespace App\Modules\Content\Controllers;

use App, Entry, View, Session, Input, Str, Config;
use App\Modules\Admin\Models\Article;
use App\Modules\Admin\Models\Comment;
use App\Modules\Admin\Models\Users;

/**
 * Content controller
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class ContentController extends \BaseController {

	public function getHome()
	{
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
		return View::make('content::index', array('article_paging' => $data, 'article' => $dataArticle, 'breadcrumb' => array()));
	}

	public function introduction(){
		$dataUser = Users::getUserWhere('*', null, '', 'department', 'ASC');
		$departments = Config::get('configuration');
		$departments = $departments['department'];
		$i = 1;
		foreach($departments as $dep){
			$departments_change[$i] = strtolower(str_replace(' ', '_', $dep));
			$i++;
		}
		foreach($dataUser as $user){
			if($user['department']){
				$key = $departments_change[$user['department']];
			}
			switch($user['department']){
				case 1: {
					$dataIntro[$key][] = $user;
					break;
				}
				case 2: {
					$dataIntro[$key][] = $user;
					break;
				}
				case 3: {
					$dataIntro[$key][] = $user;
					break;
				}
				case 4: {
					$dataIntro[$key][] = $user;
					break;
				}
				case 5: {
					$dataIntro[$key][] = $user;
					break;
				}
				default: $dataIntro = array();
			}
		}
		$breadcrumb[]['name'] = 'Giới thiệu';
		return View::make('content::introduction', array('hidden_colright' => 1, 'dataIntro' => $dataIntro, 'title' => 'Giới thiệu công ty', 'breadcrumb' => $breadcrumb, 'departments' => $departments_change));
	}
}
