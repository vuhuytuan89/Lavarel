<?php namespace App\Modules\Admin\Models;
use DB;
	class Category extends \Eloquent{
		protected $table = 'category';
		protected $primaryKey = 'cat_id';

		public $timestamps = false;

		public static function getCatAll(){
			$data = Category::all()->toArray();
			return $data;
		}

		public static function getCatAllJoin(){
			$data = Category::select('category.*', 'category_all.cat_name as cat_sub_name')
				->leftjoin(DB::raw('(SELECT * FROM category ) category_all'), function($join)
				{
					$join->on('category.cat_sub_id', '=', 'category_all.cat_id');
				})->paginate(10);
			return $data;
		}

		public static function getCatSubQuery($where = array()){
			$data = Category::select('category.*', 'category_all.cat_name as cat_sub_name', 'category_all.cat_id as cat_sub_id')
				->leftjoin(DB::raw('(SELECT * FROM category ) category_all'), function($join)
				{
					$join->on('category.cat_sub_id', '=', 'category_all.cat_id');
				})->where($where)->get();
			return $data->toArray();
		}

		public static function getCatOne($id){
			$data = Category::find($id);
			if($data){
				return $data->toArray();
			}else{
				return $data;
			}
		}

		public static function getCatWhere($col = '*', $where = array()){
			$data = Category::addSelect($col);
			if($where != null){
				$data->where($where);
			}
			return $data->get()->toArray();
		}

		public static function getCatWhereIn($col = '*', $where = array()){
			$data = Category::addSelect($col)->whereIn('cat_id', $where);
			return $data->get()->toArray();
		}

		public static function addCat($data){
			$insert = new Category();
			$insert->cat_name = $data['cat_name'];
			$insert->cat_sub_id = $data['cat_sub_id'];
			$insert->cat_check_mytour = $data['cat_check_mytour'];
			$insert->cat_is_approved = $data['cat_is_approved'];
			$result = $insert->save();
			return $result;
		}

		public static function updateCat($data, $where){
			$result = Category::where($where)->update($data);
			return $result;
		}

		public static function deleteCat($id){
			$result = Category::whereIn('cat_id', $id)->delete();
			return $result;
		}
	}