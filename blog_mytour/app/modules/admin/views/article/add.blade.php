@extends('admin::_layout.template_content')
{{ HTML::script('assets/js/ckeditor/ckeditor.js') }}

@section('main')
<div class="box-header text-right">
	<a class="btn-success blue" href="javascript:void(0)" onclick="window.history.back()">Quay lại</a>
</div>
<div class="portlet-header">
	<h4>Thêm Bài viết</h4>
</div>
<div class="portlet-content">
	{{ Form::open(array('route' => 'art.add', 'class' => 'form label-inline', 'enctype' => 'multipart/form-data'))}}
		<div class="field">
			<label for="art_title">Tiêu đề Bài viết <span class="required">*</span></label>
			<input type="text" class="xlarge" id="art_title" name="art_title" required="">
		</div>
		<div class="field">
			<label for="art_cat_id">Danh mục bài viết</label>
			<select name="art_cat_id" id="art_cat_id" class="medium">
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
			<label for="art_shortdetail">Nội dung tóm tắt <span class="required">*</span></label>

			<textarea class="xlarge" name="art_shortdetail" id="art_shortdetail" required=""></textarea>
		</div>
		<div class="field">
			<label for="art_detail">Nội dung chi tiết</label>

			<div class="textarea-ckeditor fleft"><textarea class="large ckeditor" name="art_detail" id="art_detail" required=""></textarea></div>
		</div>
		<div class="field" style="clear: both; padding-top: 15px">
			<label for="art_is_approved">Hiển thị</label>
			<select name="art_is_approved" class="medium" id="art_is_approved">
				<option value="0">Ẩn</option>
				<option value="1" selected>Hiển thị</option>
			</select>
		</div>
		<div class="field text-center">
			<button type="submit" class="btn-success blue" name="btn-submit">Thêm Bài viết</button>
			<button type="reset" class="btn-success red" id="btn_reset_art" name="btn-reset">Reset</button>
		</div>
	{{ Form::close() }}
</div>
<script>
	//js set value ckeditor when click button reset
	$('#btn_reset_art').click(function(){
		CKEDITOR.instances['art_detail'].setData('');
	});
</script>
@stop
