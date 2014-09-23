<?php
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\Users;
use App\Modules\Admin\Models\Article;
use App\Modules\Auth\Models\AuthCustomer;
use App\Modules\Admin\Models\Notify;

class BaseController extends Controller {
	public function __construct(){
		$id_usr = Session::get('infusr_id');
		$checkUserMytour = Users::checkUserInMytour($id_usr);
		$this->checkUserExist($id_usr);
		$dataUserLogin = Users::getUserOne($id_usr);
		$dataNotify = Notify::getNotifyWhereJoin(array('notify.*', 'comment.com_usr_id', 'comment.com_detail', 'comment.com_date_created', 'article.art_title'), array('not_usr_id' => $id_usr), 'not_id', 'desc', 8);
		if($dataNotify){
			$i = 0;
			foreach($dataNotify as $notify){
				$dataNotify[$i]['date_created'] = $this->calculateTime($notify['com_date_created']);
				$dataUser = AuthCustomer::getUserWhere(array('id', 'username', 'signature', 'avatar'), array('id' => $notify['com_usr_id']));
				if($dataUser){
					$dataNotify[$i]['avatar'] = $dataUser[0]['avatar'];
					$dataNotify[$i]['username'] = $dataUser[0]['username'];
					$dataNotify[$i]['signature'] = $dataUser[0]['signature'];
					$dataNotify[$i]['user_id'] = $dataUser[0]['id'];
					$dataNotify[$i]['art_seo_title'] = Str::slug($notify['art_title']);
					$i++;
				}
				else{
					$dataNotify[$i]['avatar'] = '';
					$dataNotify[$i]['username'] = '';
					$dataNotify[$i]['signature'] = '';
					$dataNotify[$i]['user_id'] = '';
					$dataNotify[$i]['art_seo_title'] = '';
					$i++;
				}
			}
		}
		$CountNotify = Notify::countNotifySee(array('not_is_approved' => 0, 'not_usr_id' => $id_usr));
		$dataMenuCheck = array();
		$dataMenu = Category::getCatWhere(array('cat_id', 'cat_name', 'cat_sub_id'), array('cat_is_approved' => 1, 'cat_sub_id' => 0, 'cat_check_mytour' => 0));
		$flag_mytour = false;
		$flag_it = false;
		if($id_usr){
			if($checkUserMytour){
				$dataMenu = Category::getCatWhere(array('cat_id', 'cat_name', 'cat_sub_id'), array('cat_is_approved' => 1, 'cat_sub_id' => 0, 'cat_check_it' => 0));
				$flag_mytour = true;
			}
			if($dataUserLogin['department'] == 2){
				$dataMenu = Category::getCatWhere(array('cat_id', 'cat_name', 'cat_sub_id'), array('cat_is_approved' => 1, 'cat_sub_id' => 0));
				$flag_it = true;
			}
		}
		if(!empty($dataMenu)){
			$i = 0;
			foreach($dataMenu as $menu){
				if($flag_mytour){
					if($flag_it){
						$dataSubMenu = Category::getCatWhere(array('cat_id', 'cat_name'), array('cat_is_approved' => 1, 'cat_sub_id' => $menu['cat_id']));
					}else{
						$dataSubMenu = Category::getCatWhere(array('cat_id', 'cat_name'), array('cat_is_approved' => 1, 'cat_sub_id' => $menu['cat_id'], 'cat_check_it' => 0));
					}
				}else{
					$dataSubMenu = Category::getCatWhere(array('cat_id', 'cat_name'), array('cat_is_approved' => 1, 'cat_sub_id' => $menu['cat_id'], 'cat_check_mytour' => 0));
				}
					if($dataSubMenu){
						$dataMenu[$i]['dataSubMenu'] = $dataSubMenu;
						$j = 0;
						foreach($dataSubMenu as $sub){
							$dataMenu[$i]['dataSubMenu'][$j]['cat_sub_seo_name'] = Str::slug($sub['cat_name']);
							$j++;
						}
					}
					$dataMenu[$i]['cat_seo_name'] = Str::slug($menu['cat_name']);
					$i++;
				}
		}

		// echo '<pre>';
		// print_r($dataMenu);
		// echo '</pre>';die;
		$dataBlogger = Users::getUserWhere(array('signature', 'id', 'username', 'avatar'), array('is_approved' => 1, 'level' => 2));
		if($dataBlogger){
			$i = 0;
			foreach($dataBlogger as $usr){
				$dataArt = Article::getArtWhereCount('art_id', array('art_usr_id' => $usr['id']));
				if($dataArt){
					$dataBlogger[$i]['count_art'] = $dataArt;
				}
				else{
					$dataBlogger[$i]['count_art'] = 0;
				}
				$i++;
			}
		}
		if($checkUserMytour){
			if($checkUserMytour[0]['department'] == 2){
				$dataBlogNew = Article::getArtWhereJoinCat(array('article.art_id', 'article.art_title', 'article.art_shortdetail'), array('article.art_is_approved' => 1), 'art_id', 'desc', 10);
			}else{
				$dataBlogNew = Article::getArtWhereJoinCat(array('article.art_id', 'article.art_title', 'article.art_shortdetail'), array('article.art_is_approved' => 1, 'category.cat_check_it' => 0), 'art_id', 'desc', 10);
			}
		}else{
			$dataBlogNew = Article::getArtWhereJoinCat(array('article.art_id', 'article.art_title', 'article.art_shortdetail'), array('article.art_is_approved' => 1, 'category.cat_check_mytour' => 0), 'art_id', 'desc', 10);
		}
		if($dataBlogNew){
			$j = 0;
			foreach($dataBlogNew as $new){
					$dataBlogNew[$j]['art_seo_title'] = Str::slug($new['art_title']);
				$j++;
			}
		}
		$breadcrumb[] = array('name' => 'Trang chủ');
		$dataBlogHot = Article::getArtWhere(array('art_id', 'art_title', 'art_shortdetail'), array('art_is_approved' => 1), 'art_date_created', 'DESC', 10);
		View::share(array('dataMenu' =>$dataMenu, 'dataBlogger' => $dataBlogger, 'dataBlogNew' => $dataBlogNew, 'dataBlogHot' => $dataBlogHot, 'dataNotify_header' => $dataNotify, 'countNotify' => $CountNotify, 'dataUserLogin' => $dataUserLogin));
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function calculateTime($time_to_calculate)
	{
		$time_now = intval(time());
		$temp_time = intval($time_to_calculate);
		$distance_time = $time_now - $temp_time;

		if($distance_time == 1)
		{
			return "Khoảng 1 giây trước";
		}
		else if(ceil($distance_time/60) == 1)
		{
			return "Khoảng 1 phút trước";
		}
		else if(ceil($distance_time/60) > 1 && ceil($distance_time/60) < 60)
		{
			return "Khoảng ".ceil($distance_time/60)." phút trước";
		}
		else if(ceil($distance_time/(60*60)) == 1)
		{
			return "Khoảng 1 giờ trước";
		}
		else if(ceil($distance_time/(60*60)) < 24)
		{
			return "Khoảng ".ceil($distance_time/(60*60))." giờ trước";
		}
		else if(ceil($distance_time/(60*60*24)) == 1)
		{
			return "Khoảng 1 ngày trước";
		}
		else if(ceil($distance_time/(60*60*24)) < 7)
		{
			return "Khoảng ".ceil($distance_time/(60*60*24))." ngày trước";
		}
		else if(ceil($distance_time/(60*60*24*7)) == 1)
		{
			return "Khoảng 1 tuần trước";
		}
		else if(ceil($distance_time/(60*60*24*7)) < 4)
		{
			return "Khoảng ".ceil($distance_time/(60*60*24*7))." tuần trước";
		}
		else if(ceil($distance_time/(60*60*24*7*4)) == 1)
		{
			return "Khoảng 1 tháng trước";
		}
		else
		{
			return date('d/m/Y H:i', $time_to_calculate);
		}
	}

	protected function checkUserExist($id){
		$check = Users::getUserOne($id);
		if(!$check){
			Session::forget('infusr');
			Session::forget('infusr_id');
			Session::forget('infusr_signature');
		}
	}
}