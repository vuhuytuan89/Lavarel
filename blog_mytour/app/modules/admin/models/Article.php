<?php namespace App\Modules\Admin\Models;
use DB;
class Article extends \Eloquent{
	protected $table = 'article';
	protected $primaryKey = 'art_id';

	public $timestamps = false;

	public static function getArtAll(){
		$data = Article::all()->toArray();
		return $data;
	}

	public static function getArtAllJoin(){
		$data = Article::select('article.*', 'category.cat_name', 'users.username')
			->leftjoin('category', function($join)
			{
				$join->on('article.art_cat_id', '=', 'category.cat_id');
			})
			->leftjoin('users', function($join)
			{
				$join->on('article.art_usr_id', '=', 'users.id');
			})->orderby('art_date_created', 'desc')->paginate(10);
		return $data;
	}

	public static function getArtOne($id){
		$data = Article::find($id);
		if($data){
			return $data->toArray();
		}else{
			return $data;
		}
	}

	public static function getArtWhere($col = '*', $where = array(), $order = '', $sort = 'asc', $limit = ''){
		$data = Article::addSelect($col);
		if($where != null){
			$data->where($where);
		}
		if($order != null){
			$data->orderBy($order, $sort);
		}
		if($limit != null){
			$data->take($limit);
		}
		return $data->get()->toArray();
	}

	public static function getArtWhereCount($col = '*', $where = array()){
		$data = Article::addSelect($col);
		if($where != null){
			$data->where($where);
		}
		return $data->count();
	}

	public static function getArtWhereJoin($col = '*', $where = array(), $order = '', $sort = 'asc', $paginate){
		$data = Article::addSelect($col)
						->leftjoin('users', 'article.art_usr_id', '=', 'users.id')
						->leftjoin('category', 'article.art_cat_id', '=', 'category.cat_id')
						->where($where)->orderby($order, $sort)->paginate($paginate);
		return $data;
	}

	public static function getArtWhereJoinCat($col = '*', $where = array(), $order = '', $sort = 'asc', $limit){
		$data = Article::addSelect($col)
						->leftjoin('category', 'article.art_cat_id', '=', 'category.cat_id')
						->where($where)->orderby($order, $sort)->limit($limit)->get()->toArray();
		return $data;
	}

	public static function getArtWhereLikeJoin($col = '*', $key, $where, $order = '', $sort = 'asc', $paginate){
		$data = Article::addSelect($col)
			->leftjoin('users', 'article.art_usr_id', '=', 'users.id')
			->leftjoin('category', 'article.art_cat_id', '=', 'category.cat_id')
			->where('art_title', 'LIKE', '%'.$key.'%')
			->where($where)
			->orderby($order, $sort);
		return $data;
	}

	public static function getArtWhereInJoin($col = '*', $where = array(), $whereIn, $order = '', $sort = 'asc', $paginate){
		$data = Article::addSelect($col)
			->leftjoin('users', 'article.art_usr_id', '=', 'users.id')
			->leftjoin('category', 'article.art_cat_id', '=', 'category.cat_id')
			->where($where)->whereIn('art_cat_id', $whereIn)->orderby($order, $sort)->paginate($paginate);
		return $data;
	}

	public static function getArtWhereJoinUser($col = '*', $where = array(), $whereIn = array()){
		$data = Article::addSelect($col)
			->leftjoin('users', 'article.art_usr_id', '=', 'users.id')
			->where($where)->whereIn('art_cat_id',$whereIn)->get()->toArray();
		return $data;
	}

	public static function getArtWhereIn($col = '*', $colwhere, $data = array()){
		$data = Article::select($col)->whereIn($colwhere, $data);
		return $data->get()->toArray();
	}

	public static function addArt($data){
		$result = Article::insert($data);
		return $result;
	}

	public static function updateArt($data, $where){
		$result = Article::where($where)->update($data);
		return $result;
	}

	public static function deleteArtWhereIn($col, $id){
		$result = Article::whereIn($col, $id)->delete();
		return $result;
	}
}