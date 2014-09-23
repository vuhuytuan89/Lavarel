@extends('admin::_layout.template_content')

@section('main')
<div class="portlet-header">
	<h4>Thay đổi mật khẩu</h4>
</div>
<div class="portlet-content">
		<?php echo (Session::get('error'))?'<div id="alert_error"><label>' . Session::get('error') . '</label></div>':''; ?>
		<?php echo (Session::get('success'))?'<div id="alert_success"><label>' . Session::get('success') . '</label></div>':''; ?>
		{{ Form::open(array('route' => array('admin.changepass'), 'class' => 'reset-pass form label-inline')) }}
			<div class="field">
				<label for="password_old">Mật khẩu cũ <span class="required">*</span></label>
				<input type="password" name="password_old" id="password_old" class="medium" value="" placeholder="Mật khẩu cũ">
			</div>
			<div class="field">
				<label for="password_new">Mật khẩu Mới <span class="required">*</span></label>
				<input type="password" name="password_new" id="password_new" class="medium" value="" placeholder="Mật khẩu mới">
			</div>
			<div class="field">
				<label for="password_new_conf">Nhập lại mật khẩu mới <span class="required">*</span></label>
				<input type="password" name="password_new_conf" id="password_new_conf" class="medium" value="" placeholder="Nhập lại mật khẩu mới">
			</div>
			<div class="field">
				<button type="submit" class="btn-success blue">Đổi mật khẩu</button>
			</div>
		{{ Form::close() }}
	</div>
{{ HTML::script('backend/assets/js/jquery.validate.min.js') }}
<script>
	$.validator.addMethod("checkpass", function(value, element) {
		var username = "{{Auth::user()->username}}";
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("admin.ajaxpasslogin")}}',
			data: {password: value, username: username},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return false; else return true;
	} ,"Mật khẩu cũ không đúng");

	$.validator.setDefaults({ onkeyup: false });
	$(".reset-pass").validate({
		errorElement: 'span',
		onfocusout: function(element) {
			this.element(element);
		},
		rules:{
			password_old: {
				required: true,
				checkpass: true
			},
			password_new: {
				required: true,
				minlength: 6
			},
			password_new_conf: {
				equalTo: '#password_new'
			}
		},
		messages:{
			password_old:{
				required: 'Trường này không được để trống'
			},
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