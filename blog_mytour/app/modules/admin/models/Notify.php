<?php namespace App\Modules\Admin\Models;

class Notify extends \Eloquent{
	protected $table = 'notify';
	protected $primaryKey = 'not_id';

	public $timestamps = false;

	public static function getNotifyAll(){
		$data = Notify::all()->toArray();
		return $data;
	}

	public static function getNotifyOne($id){
		$data = Notify::find($id);
		if($data){
			return $data->toArray();
		}else{
			return $data;
		}
	}

	public static function countNotifySee($where){
		$data = Notify::addselect('not_id')->where($where)->get()->toArray();
		return count($data);
	}

	public static function getNotifyWhere($col = '*', $where = array(), $order, $sort, $limit){
		$data = Notify::select($col)->where($where)->orderby($order, $sort)->limit($limit);
		return $data->get()->toArray();
	}

	public static function getNotifyWhereJoin($col = '*', $where = array(), $order, $sort, $limit){
		$data = Notify::select($col)
						->leftjoin('article', function($join)
						{
							$join->on('notify.not_art_id', '=', 'article.art_id');
						})
						->leftjoin('comment', function($join)
						{
							$join->on('notify.not_com_id', '=', 'comment.com_id');
						});
			if($where != null){
				$data->where($where);
			}
			$data->orderby($order, $sort)->limit($limit);
		return $data->get()->toArray();
	}

	public static function getNotifyWherePaging($col = '*', $where = array(), $order, $sort){
		$data = Notify::select($col)
			->leftjoin('article', function($join)
			{
				$join->on('notify.not_art_id', '=', 'article.art_id');
			})
			->leftjoin('comment', function($join)
			{
				$join->on('notify.not_com_id', '=', 'comment.com_id');
			})->where($where)->orderby($order, $sort)->paginate(10);
		return $data;
	}

	public static function getNotifyWhereIn($col = '*', $where = array()){
		$data = Notify::addSelect($col)->whereIn('not_id', $where);
		return $data->get()->toArray();
	}

	public static function addNotify($data){
		$result = Notify::insert($data);
		return $result;
	}

	public static function updateNotify($data, $where){
		$result = Notify::where($where)->update($data);
		return $result;
	}

	public static function deleteNotifyWhere($col, $id){
		$result = Notify::whereIn($col, $id)->delete();
		return $result;
	}
}