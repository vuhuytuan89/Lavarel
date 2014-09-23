@extends('admin::_layout.template_content')

@section('main')
<div class="box-header text-right">
	<a class="btn-success blue" href="javascript:void(0)" onclick="window.history.back()">Quay lại</a>
</div>
<div class="portlet-header">
	<h4>Thay đổi mật khẩu</h4>
</div>
<div class="portlet-content">
	@if (Session::has('error'))
		<div id="alert_error">{{ Session::get('error') }}</div>
	@endif
		{{ Form::open(array('class' => 'reset-pass form label-inline')) }}
			<div class="field">
				<label for="password_new">Mật khẩu Mới</label>
				<input type="password" name="password_new" id="password_new" class="medium" value="" placeholder="Mật khẩu mới">
			</div>
			<div class="field">
				<label for="password_new_conf">Nhập lại mật khẩu mới</label>
				<input type="password" name="password_new_conf" id="password_new_conf" class="medium" value="" placeholder="Nhập lại mật khẩu mới">
			</div>
			<div class="field">
				<button type="submit" class="btn-success blue">Đổi mật khẩu</button>
			</div>
		{{ Form::close() }}
	</div>
{{ HTML::script('backend/assets/js/jquery.validate.min.js') }}
<script>
	$.validator.setDefaults({ onkeyup: false });
	$(".reset-pass").validate({
		errorElement: 'span',
		onfocusout: function(element) {
			this.element(element);
		},
		rules:{
			password_new: {
				required: true,
				minlength: 6
			},
			password_new_conf: {
				equalTo: '#password_new'
			}
		},
		messages:{
			password_new: {
				required: 'Trường này không được để trống',
				minlength: 'Hãy nhập vào tối thiểu 6 ký tự'
			},
			password_new_conf: {
				equalTo: 'Mật khẩu nhập lại không đúng'
			}
		}
	});
</script>
@stop