<?php namespace App\Modules\Content\Models;

Class Content extends \Eloquent{
	protected $table = 'article';
	protected $primaryKey = 'art_id';

	public $timestamps = false;

	public static function getConAll(){
		$data = Content::all()->toArray();
		return $data;
	}

	public static function getConAllJoin(){
		$data = Content::select('article.*', 'category.cat_name', 'users.username')
			->leftjoin('category', function($join)
			{
				$join->on('article.art_cat_id', '=', 'category.cat_id');
			})
			->leftjoin('users', function($join)
			{
				$join->on('article.art_usr_id', '=', 'users.id');
			})
			->get();
		return $data->toArray();
	}

	public static function getConOne($id){
		$data = Content::find($id);
		if($data){
			return $data->toArray();
		}else{
			return $data;
		}
	}

	public static function getConWhere($col = '*', $where = array()){
		$data = Content::addSelect($col);
		if($where != null){
			$data->where($where);
		}
		return $data->get()->toArray();
	}

	public static function getConWhereIn($col = '*', $where = array()){
		$data = Content::addSelect($col);
		if($where != null){
			$data->whereIn('art_id', $where);
		}
		return $data->get()->toArray();
	}

	public static function addCon($data){
		$result = Content::insert($data);
		return $result;
	}

	public static function updateCon($data, $where){
		$result = Content::where($where)->update($data);
		return $result;
	}

	public static function deleteCon($id){
		$result = Users::whereIn('art_id', $id)->delete();
		return $result;
		return $result;
	}
}