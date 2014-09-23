<?php namespace App\Modules\Admin\Controllers;

use Input, Redirect, View, URL;
use App\Modules\Admin\Models\Category;

class CategoryController extends \BaseController
{

	public function index()
	{
		$data = Category::getCatAllJoin();
		$dataCat = $data->toArray();
		return View::make('admin::category.index', array('category' => $dataCat['data'], 'dataPaging' => $data));
	}

	public function add(){
		$data['dataCatParent'] = Category::getCatWhere(array('cat_id', 'cat_sub_id','cat_name'), array('cat_sub_id' => 0));
		if($data['dataCatParent']){
			$i = 0;
			foreach($data['dataCatParent'] as $val){
				$dataCatChild = Category::getCatWhere(array('cat_id','cat_name'), array('cat_sub_id' => $val['cat_id']));
				if($dataCatChild){
					$data['dataCatParent'][$i]['dataCatChild'] = $dataCatChild;
				}
				$i++;
			}
		}
//		echo '<pre>';
//		print_r($data);
//		echo '</pre>';die;

		if($_POST){
			$input = Input::only('cat_name', 'cat_sub_id', 'cat_check_mytour', 'cat_is_approved');
			$result = Category::addCat($input);
			if($result){
				return Redirect::route('cat.category')->with('alert', 'Bạn đã thêm thành công');
			}
			else{
				return Redirect::route('cat.category')->with('alert', 'Lỗi, bạn hãy thử lại');
			}
		}
		return View::make('admin::category.add', $data);
	}

	public function edit($id){
		$data['dataCat'] = Category::getCatOne($id);
		$data['dataCatParent'] = Category::getCatWhere(array('cat_id', 'cat_name', 'cat_sub_id'), array('cat_sub_id' => 0));
		if($data['dataCatParent']){
			$i = 0;
			foreach($data['dataCatParent'] as $val){
				$dataCatChild = Category::getCatWhere(array('cat_id','cat_name', 'cat_sub_id'), array('cat_sub_id' => $val['cat_id']));
				if($dataCatChild){
					$data['dataCatParent'][$i]['dataCatChild'] = $dataCatChild;
				}
				$i++;
			}
		}

		if($_POST){
			$input = Input::only('cat_name', 'cat_sub_id',  'cat_check_mytour', 'cat_is_approved');
			$result = Category::updateCat($input, array('cat_id' => $id));
			if($result){
				return Redirect::route('cat.category');
			}
		}
		return View::make('admin::category.edit', $data);
	}

	public function delete($id){
		$id = explode(',', $id);
		$dataCat = Category::getCatWhereIn(array('cat_id', 'cat_sub_id'), $id);
		$result = Category::deleteCat($id);
		if($result){
			foreach($dataCat as $cat){
				$dataCatChild = Category::getCatWhere('cat_id', array('cat_sub_id' => $cat['cat_id']));
				if($dataCatChild){
					foreach($dataCatChild as $child){
						Category::deleteCat($child['cat_id']);
					}
				}
			}
			return Redirect::route('cat.category');
		}
	}

	public function active(){
		$url = URL::to('/');
		$id = Input::get('id');
		$cat_sub_id = Input::get('cat_sub_id');
		$val = Input::get('val');
		$col = Input::get('col');
		$html = '';
		if($val == 1){
			$val = 0;
		}else{
			$val = 1;
		}
		$dataUpdate["$col"] = $val;
		$dataHtml = array();
		$result = Category::updateCat($dataUpdate, array('cat_id' => $id));
		if($result){
			$html = '<a href="javascript:void(0)" onclick="change_value_check('.$id .','. $val .', &#39;'. $col .'&#39;,'. $cat_sub_id.')">';
			$html .= '<img src="'.$url.'/backend/assets/images/'.$val.'.png">';
			$html .= '<input type="hidden" id="'.Input::get('col').$id.$cat_sub_id.'" value="'.$val.'"></a>';
			$dataHtml[0]['html'] = $html;
			$dataHtml[0]['cat_id'] = $id;
		}
		if($col == 'cat_check_mytour' || $col == 'cat_check_it'){
			if($cat_sub_id == 0){
				if($val){
					$dataCatChild = Category::getCatWhere(array('cat_id', 'cat_sub_id'), array('cat_sub_id' => $id));
					if($dataCatChild){
						$i = 1;
						foreach($dataCatChild as $child){
							$result1 = Category::updateCat($dataUpdate, array('cat_id' => $child['cat_id']));
							$html_sub_cat = '<a href="javascript:void(0)" onclick="change_value_check('.$child['cat_id'] .','. $val .', &#39;'. $col .'&#39;,'. $child['cat_sub_id'].')">';
							$html_sub_cat .= '<img src="'.$url.'/backend/assets/images/'.$val.'.png">';
							$html_sub_cat .= '<input type="hidden" id="'.Input::get('col').$id.$child['cat_sub_id'].'" value="'.$val.'"></a>';
							$dataHtml[$i]['html'] = $html_sub_cat;
							$dataHtml[$i]['cat_id'] = $child['cat_id'];
							$i++;
						}
					}
				}
			}
		}elseif($col == 'cat_is_approved'){
			if($cat_sub_id == 0){
				if(!$val){
					$dataCatChild = Category::getCatWhere(array('cat_id', 'cat_sub_id'), array('cat_sub_id' => $id));
					if($dataCatChild){
						$i = 1;
						foreach($dataCatChild as $child){
							$result1 = Category::updateCat($dataUpdate, array('cat_id' => $child['cat_id']));
							$html_sub_cat = '<a href="javascript:void(0)" onclick="change_value_check('.$child['cat_id'] .','. $val .', &#39;'. $col .'&#39;,'. $child['cat_sub_id'].')">';
							$html_sub_cat .= '<img src="'.$url.'/backend/assets/images/'.$val.'.png">';
							$html_sub_cat .= '<input type="hidden" id="'.Input::get('col').$id.$child['cat_sub_id'].'" value="'.$val.'"></a>';
							$dataHtml[$i]['html'] = $html_sub_cat;
							$dataHtml[$i]['cat_id'] = $child['cat_id'];
							$i++;
						}
					}
				}
			}
		}
		return json_encode($dataHtml);
	}
}