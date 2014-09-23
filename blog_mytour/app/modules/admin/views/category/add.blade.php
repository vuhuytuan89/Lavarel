@extends('admin::_layout.template_content')

@section('main')
<div class="box-header text-right">
	<a class="btn-success blue" href="javascript:void(0)" onclick="window.history.back()">Quay lại</a>
</div>
<div class="portlet-header">
	<h4>Thêm Danh mục</h4>
</div>
<div class="portlet-content">
	{{ Form::open(array('route' => 'cat.add', 'class' => 'form label-inline', 'id' => 'category_add'))}}
		<div class="field">
			<label for="cat_name">Tên Danh mục <span class="required">*</span></label>
			<input type="text" class="large" id="cat_name" name="cat_name" required="">
		</div>
		<div class="field">
			<label for="cat_sub_id">Danh mục gốc</label>
			<select name="cat_sub_id" id="cat_sub_id" class="medium">
				<option value="0">-- Chọn Category --</option>
				@if($dataCatParent)
					@foreach($dataCatParent as $cat)
						<option value="{{$cat['cat_id']}}">-- {{$cat['cat_name']}}</option>
						@if(isset($cat['dataCatChild']))
							@foreach($cat['dataCatChild'] as $child)
								<option value="{{$child['cat_id']}}">------ {{$child['cat_name']}}</option>
							@endforeach
						@endif
					@endforeach
				@endif
			</select>
		</div>
		<div class="field">
			<label for="cat_check_mytour">Check Mytour</label>
			<select name="cat_check_mytour" class="medium" id="cat_check_mytour">
				<option value="0">Không</option>
				<option value="1">Có</option>
			</select>
		</div>
		<div class="field">
			<label for="cat_check_it">Check IT</label>
			<select name="cat_check_it" class="medium" id="cat_check_it">
				<option value="0">Không</option>
				<option value="1">Có</option>
			</select>
		</div>
		<div class="field">
			<label for="cat_is_approved">Hiển thị</label>
			<select name="cat_is_approved" class="medium" id="cat_is_approved">
				<option value="0">Ẩn</option>
				<option value="1" selected>Hiển thị</option>
			</select>
		</div>
		<div class="field">
			<button type="submit" class="btn-success blue" name="btn-submit">Thêm Danh mục</button>
			<button type="reset" class="btn-success red" name="btn-reset">Reset</button>
		</div>
	{{ Form::close() }}
</div>
@stop