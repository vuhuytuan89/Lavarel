@extends('content::_layout.default')

@section('main')
	<div class="form-blogger">
		<h1>Đổi Mật Khẩu</h1>
		<?php echo (Session::get('error'))?'<div class="alert-error"><label>' . Session::get('error') . '</label></div>':''; ?>
		{{ Form::open(array('route' => array('usr.resetpass'), 'class' => 'reset-pass')) }}
		<ul>
			<li>
				<label for="password_old">Mật khẩu cũ <span class="required">*</span></label>
				<div><input type="password" name="password_old" id="password_old" class="txt" value="" placeholder="Mật khẩu cũ"></div>
			</li>
			<li>
				<label for="password_new">Mật khẩu Mới <span class="required">*</span></label>
				<div><input type="password" name="password_new" id="password_new" class="txt" value="" placeholder="Mật khẩu mới"></div>
			</li>
			<li>
				<label for="password_new_conf">Nhập lại mật khẩu mới <span class="required">*</span></label>
				<div><input type="password" name="password_new_conf" id="password_new_conf" class="txt" value="" placeholder="Nhập lại mật khẩu mới"></div>
			</li>
			<li>
				<input type="hidden" name="username" value="{{$username}}" id="username">
				<input type="submit" name="submit" class="btn_blue" value="Cập nhật">
			</li>
		</ul>
		{{ Form::close() }}
	</div>
{{ HTML::script('backend/assets/js/jquery.validate.min.js') }}
<script>
	$.validator.addMethod("checkpass", function(value, element) {
		var username = $("#username").val();
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("checkpass")}}',
			data: {password: value, username: username},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return false; else return true;
	} ,"Mật khẩu cũ không đúng");

	$.validator.setDefaults({ onkeyup: false });
	$(".reset-pass").validate({
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