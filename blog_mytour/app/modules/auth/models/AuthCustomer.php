<?php namespace App\Modules\Auth\Models;


Class AuthCustomer extends \Eloquent
{

	protected $table = 'users';

	public static function getUserWhere($col = '*', $where = array()){
		$data = AuthCustomer::addselect($col)->where($where)->get()->toArray();
		return $data;
	}

	public static function addUser($data)
	{
		$result = AuthCustomer::insert($data);
		return $result;
	}

	public static function updateUser($data, $where)
	{
		$result = AuthCustomer::where($where)->update($data);
		return $result;
	}

	public static function deleteUser($id)
	{
		$result = AuthCustomer::whereIn('id', $id)->delete();
		return $result;
	}

}