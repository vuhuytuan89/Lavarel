@extends('content::_layout.default')

@section('main')
<div class="reg_form">
	<h1>Đăng nhập</h1>
	<?php echo (Session::get('error'))?'<div class="alert-error"><label>' . Session::get('error') . '</label></div>':''; ?>
	<?php echo (Session::get('success'))?'<div class="alert-success"><label>' . Session::get('success') . '</label></div>':''; ?>
	{{ Form::open(array('route' => 'login.post', 'class' => 'login-form')) }}
		<ul>
			<li>
				<label>Tên đăng nhập <span class="required">*</span></label>
				<div><input type="text" name="username" id="username" class="txt" value="" placeholder="Tên đăng nhập"></div>
			</li>
			<li>
				<label>Mật khẩu <span class="required">*</span></label>
				<div><input type="password" name="password" class="txt" placeholder="Mật khẩu"></div>
			</li>
			<li class="button">
				<a href="{{route('remindpass')}}" class="acc">Quên mật khẩu?</a>
				<input type="submit" name="login-submit" class="btn_blue" value="Đăng nhập">
				<div class="clrb"></div>
			</li>
		</ul>
	{{ Form::close() }}
</div>
{{ HTML::script('/backend/assets/js/jquery.validate.min.js') }}

<script>
	$.validator.addMethod("checkusername", function(value, element) {
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("checkusername")}}',
			data: {username: value},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return false; else return true;
	} ,"Tên đăng nhập không đúng");

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
	} ,"Mật khẩu không đúng");

	$.validator.setDefaults({ onkeyup: false });
	$(".login-form").validate({
		onfocusout: function(element) {
			this.element(element);
		},
		rules:{
			username: {
				required: true,
				checkusername: true
			},
			password: {
				required: true,
				checkpass: true,
				minlength: 6
			}
		},
		messages:{
			username:{
				required: 'Trường này không được để trống'
			},
			password: {
				required: 'Trường này không được để trống',
				minlength: 'Hãy nhập vào tối thiểu 6 ký tự'
			}
		}
	});
</script>
@stop