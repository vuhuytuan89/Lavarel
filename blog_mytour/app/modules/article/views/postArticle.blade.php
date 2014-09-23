@extends('content::_layout.default')

@section('main')
		<div class="form-postnews">
			<div class="box-heading"><h3>Đăng bài mới</h3></div>
			{{Form::open(array('enctype' => 'multipart/form-data', 'id' => 'form-postnew'))}}
			<div class="field">
				<label for="art_title">Tiêu đề bài viết <span class="required">*</span></label>
				<div class="form-input">
					<input type="text" name="art_title" id="art_title">
				</div>
			</div>
			<div class="field">
				<label for="art_cat_id">Danh mục bài viết</label>
				<div class="form-input">
					<select name="art_cat_id" id="art_cat_id">
						<option value="0">-- Chọn danh mục bài viết --</option>
						@if($dataCatParent)
							@foreach($dataCatParent as $cat)
								<option value="{{$cat['cat_id']}}">--{{$cat['cat_name']}}</option>
								@if(isset($cat['dataCatChild']))
									@foreach($cat['dataCatChild'] as $child)
										<option value="{{$child['cat_id']}}">----{{$child['cat_name']}}</option>
									@endforeach
								@endif
							@endforeach
						@endif
					</select>
				</div>
			</div>
			<div class="field">
				<label for="art_shortdetail">Tóm tắt <span class="required">*</span></label>
				<div class="form-input">
					<textarea name="art_shortdetail" id="art_shortdetail"></textarea>
				</div>
			</div>
			<div class="field">
				<label for="art_detail">Chi tiết</label>
				<div class="form-input">
					<textarea name="art_detail" id="art_detail" class="art_detail"></textarea>
				</div>
			</div>
			<div class="field text-right">
				<div>
					<button type="submit" class="btn_blue">Đăng bài</button>
				</div>
			</div>
			{{Form::close()}}
		</div>
{{ HTML::script('backend/assets/js/jquery.validate.min.js') }}
{{ HTML::script('assets/js/ckeditor/ckeditor.js') }}
		<script type="text/javascript">
				CKEDITOR.replace( 'art_detail', {
					toolbar: [
						{ name: 'document', items: [ 'Source', '-', 'Preview', '-', 'Templates', '-', 'Undo', 'Redo'  ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
						// '/',
						{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
						{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
						{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat' ] },
						{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
						{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor' ] },
					]
				});
		</script>
<script>
	$.validator.addMethod("checktitle", function(value, element) {
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("checktitle")}}',
			data: {title: value},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return true; else return false;
	} ,"Tiêu đề bài viết đã tồn tại");

	$.validator.setDefaults({ onkeyup: false });
	$("#form-postnew").validate({
		onfocusout: function(element) {
			this.element(element);
		},
		rules:{
			art_title: {
				required: true,
				checktitle: true
			},
			art_shortdetail: {
				required: true
			},
			art_detail: {
				required: true
			}
		},
		messages:{
			art_title:{
				required: 'Trường này không được để trống'
			},
			art_shortdetail: {
				required: 'Trường này không được để trống'
			},
			art_detail: {
				required: 'Trường này không được để trống'
			}
		}
	});
</script>
@stop