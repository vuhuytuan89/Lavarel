<?php namespace App\Modules\Admin\Models;

use DB;
class Comment extends \Eloquent{
	protected $table = 'comment';
	protected $primaryKey = 'com_id';

	public $timestamps = false;

	public static function getComAll(){
		$data = Comment::all()->toArray();
		return $data;
	}

	public static function getComAllJoin($where = array(), $order = 'com_id', $sort = 'asc'){
		$data = Comment::select('comment.*', 'article.art_title', 'users.username', 'users.id as usr_id', 'users.avatar')
			->leftjoin('article', function($join)
			{
				$join->on('comment.com_art_id', '=', 'article.art_id');
			})
			->leftjoin('users', function($join)
			{
				$join->on('comment.com_usr_id', '=', 'users.id');
			})->where($where)->orderby($order, $sort);
		return $data->get()->toArray();
	}

	public static function getComAllJoinPaging($where = array(), $paging = 5, $order = 'com_id', $sort = 'asc'){
		$data = Comment::select('comment.*', 'article.art_title', 'users.username', 'users.id as usr_id', 'users.avatar')
			->leftjoin('article', function($join)
			{
				$join->on('comment.com_art_id', '=', 'article.art_id');
			})
			->leftjoin('users', function($join)
			{
				$join->on('comment.com_usr_id', '=', 'users.id');
			})->where($where)->orderby($order, $sort)->paginate($paging);
		return $data;
	}

	public static function getComAllJoinLimit($where = array(), $skip = 0, $take = 15, $order = 'com_id', $sort = 'asc'){
		$data = Comment::select('comment.*', 'article.art_title', 'users.username', 'users.id as usr_id', 'users.avatar')
			->leftjoin('article', function($join)
			{
				$join->on('comment.com_art_id', '=', 'article.art_id');
			})
			->leftjoin('users', function($join)
			{
				$join->on('comment.com_usr_id', '=', 'users.id');
			})->where($where)->orderby($order, $sort)->skip($skip)->take($take)->get()->toArray();
		return $data;
	}

	public static function getComOne($id){
		$data = Comment::find($id);
		if($data){
			return $data->toArray();
		}else{
			return $data;
		}
	}

	public static function getComWhere($col = '*', $where = array()){
		$data = Comment::addSelect($col);
		if($where != null){
			$data->where($where);
		}
		return $data->get()->toArray();
	}

	public static function getComWhereCount($col = '*', $where = array()){
		$data = Comment::addSelect($col);
		if($where != null){
			$data->where($where);
		}
		return $data->count();
	}

	public static function getComWhereGroup($where = array()){
		$data = $users = DB::table('article')
			->select(DB::raw('count(comment.com_art_id) as count, art_id, art_title'))
			->leftjoin('comment', 'article.art_id', '=', 'comment.com_art_id')
			->where($where)
			->groupBy('comment.com_art_id')
			->orderby('count', 'desc')->limit(3)
			->get();
		return $data;
	}

	public static function getComWhereIn($col = '*', $where = array()){
		$data = Comment::addSelect($col)->whereIn('com_id', $where);
		return $data->get()->toArray();
	}

	public static function addCom($data){
		$comment = new Comment();
		$comment->com_usr_id = $data['com_usr_id'];
		$comment->com_art_id = $data['com_art_id'];
		$comment->com_detail = $data['com_detail'];
		$comment->com_quote_id = $data['com_quote_id'];
		$comment->com_date_created = $data['com_date_created'];
		$comment->com_is_approved = $data['com_is_approved'];
		$comment->save();
		return $comment->com_id;
	}

	public static function updateCom($data, $where){
		$result = Comment::where($where)->update($data);
		return $result;
	}

	public static function deleteComWhere($col, $id){
		$result = Comment::whereIn($col, $id)->delete();
		return $result;
	}
}