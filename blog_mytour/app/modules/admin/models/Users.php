<?php namespace App\Modules\Admin\Models;

class Users extends \Eloquent{
	protected $table = 'users';

	public static function getUserAll(){
		$data = Users::all()->toArray();
		return $data;
	}

	public static function getUserOne($id){
		$data = Users::find($id);
		if($data){
			return $data->toArray();
		}else{
			return $data;
		}
	}

	public static function getUserWhere($col = '*', $where = array(), $limit = '', $order = '', $sort = ''){
		$data = Users::addSelect($col);
		if($where != null){
			$data->where($where);
		}
		if($order != ''){
			$data->orderby($order, $sort);
		}
		if($limit != ''){
			$data->limit($limit);
		}
		return $data->get()->toArray();
	}

	public static function checkUserInMytour($id){
		$data = Users::select('id', 'department')
						  ->where(array('is_approved' => 1, 'id' => $id, 'check_mytour' => 1))
						  ->orwhere(array('is_approved' => 1, 'id' => $id, 'level' => 1))->get()->toArray();
	  return $data;
	}

	public static function getUserOrWhere($col = '*', $where = array(), $orwhere, $limit = '', $order = '', $sort = ''){
		$data = Users::addSelect($col);
		if($where != null){
			$data->where($where);
		}
		if($orwhere != null){
			$data->orwhere($orwhere);
		}
		if($order != ''){
			$data->orderby($order, $sort);
		}
		if($limit != ''){
			$data->limit($limit);
		}
		return $data->get()->toArray();
	}

	public static function getUserWherePaging($col = '*', $where = array(), $order = '', $sort = '', $paging){
		$data = Users::select($col)->where($where)->orderby($order, $sort)->paginate($paging);
		return $data;
	}

	public static function addUser($data){
		$result = Users::insert($data);
		return $result;
	}

	public static function updateUser($data, $where){
		$result = Users::where($where)->update($data);
		return $result;
	}

	public static function deleteUser($id){
		$result = Users::whereIn('id', $id)->delete();
		return $result;
	}
}