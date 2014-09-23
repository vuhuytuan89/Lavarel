@extends('admin::_layout.template_content')
{{ HTML::script('assets/js/ckeditor/ckeditor.js') }}


@section('main')
<div class="box-header text-right">
	<a class="btn-success blue" href="javascript:void(0)" onclick="window.history.back()">Quay lại</a>
</div>
<div class="portlet-header">
	<h4>Sửa Bài viết</h4>
</div>
<div class="portlet-content">
	{{ Form::open(array(URL::to('/'), 'class' => 'form label-inline', 'id' => 'form-edit','enctype' => 'multipart/form-data'))}}
	<div class="field">
		<label for="art_title">Tiêu đề Bài viết <span class="required">*</span></label>
		<input type="text" class="xlarge" id="art_title" value="{{$dataArt['art_title']}}" name="art_title" required="">
	</div>
	<div class="field">
		<label for="art_cat_id">Danh mục</label>
		<select name="art_cat_id" id="art_cat_id" class="medium">
			<option value="0">-- Chọn Category --</option>
			@if($dataCatParent)
				@foreach($dataCatParent as $cat)
					<option <?php echo ($cat['cat_id'] == $dataArt['art_cat_id'])?'selected':'' ?> value="{{$cat['cat_id']}}">-- {{$cat['cat_name']}}</option>
					@if(isset($cat['dataCatChild']))
						@foreach($cat['dataCatChild'] as $child)
							<option <?php echo ($child['cat_id'] == $dataArt['art_cat_id'])?'selected':'' ?> value="{{$child['cat_id']}}">------ {{$child['cat_name']}}</option>
						@endforeach
					@endif
				@endforeach
			@endif
		</select>
	</div>
	<div class="field">
		<label for="art_shortdetail">Nội dung tóm tắt <span class="required">*</span></label>

		<textarea class="xlarge" name="art_shortdetail" id="art_shortdetail" required="">{{ $dataArt['art_shortdetail'] }}</textarea>
	</div>
	<div class="field">
		<label for="art_detail">Nội dung chi tiết</label>

		<div class="textarea-ckeditor fleft"><textarea class="xlarge ckeditor" name="art_detail" id="art_detail" required="">{{ $dataArt['art_detail'] }}</textarea></div>
	</div>
	<div class="field">
		<label for="art_is_approved">Hiển thị</label>
		<select name="art_is_approved" class="medium" id="art_is_approved">
			<option value="0" <?php echo ($dataArt['art_is_approved'])?'selected':'' ?> >Ẩn</option>
			<option value="1" <?php echo ($dataArt['art_is_approved'])?'selected':'' ?> >Hiển thị</option>
		</select>
	</div>
	<div class="field">
		<button type="submit" class="btn-success blue" name="btn-submit">Sửa Bài viết</button>
		<button type="reset" class="btn-success red" name="btn-reset">Reset</button>
		<input type="hidden" name="art_id" value="{{$dataArt['art_id']}}" id="art_id">
	</div>
	{{ Form::close() }}
</div>
{{ HTML::script('backend/assets/js/jquery.validate.min.js') }}
	<script>

		$.validator.addMethod("checktitle", function(value, element) {
			var art_id = $('#art_id').val();
			var result = $.ajax({
				async:false,
				type: "POST",
				url: '{{route("admin.checktitle")}}',
				data: {title: value, id: art_id},
				dataType: "text"
			});
			console.log(result .responseText);
			if(result .responseText == 0) return true; else return false;
		} ,"Tiêu đề bài viết đã tồn tại");

		$.validator.setDefaults({ onkeyup: false });
		$("#form-edit").validate({
			errorElement: 'span',
			onfocusout: function(element) {
				this.element(element);
			},
			rules:{
				art_title: {
					checktitle: true
				}
			}
		});
	</script>
@stop