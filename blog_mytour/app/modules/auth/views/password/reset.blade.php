@extends('content::_layout.default')

@section('main')

<div class="reg_form">
	<h1>Quên Mật Khẩu</h1>
	<?php echo (Session::get('success'))?'<div class="alert-success"><label>' . Session::get('success') . '</label></div>':''; ?>
	<?php echo (Session::get('error'))?'<div class="alert-error"><label>' . Session::get('error') . '</label></div>':''; ?>
	{{ Form::open(array('route' => array('resetpass.post', $token), 'class' => 'reset-pass')) }}
	<ul>
		<li>
			<label for="email">Địa chỉ E-mail</label>
			<div><input type="text" name="email" id="email" class="txt" value="" placeholder="E-mail"></div>
		</li>
		<li>
			<label for="password">Password</label>
			<div><input type="password" name="password" id="password" class="txt" value="" placeholder="Password"></div>
		</li>
		<li>
			<label for="password_confirmation">Password confirm</label>
			<div><input type="password" name="password_confirmation" id="password_confirmation" class="txt" value="" placeholder="Password confirm"></div>
		</li>
		<li>
			<input type="submit" name="submit" class="btn_blue" value="Đổi mật khẩu">
		</li>
	</ul>
	{{ Form::hidden('token', $token) }}
	{{ Form::close() }}
</div>
{{ HTML::script('backend/assets/js/jquery.validate.min.js') }}

<script>
	$.validator.addMethod("checkemail", function(value, element) {
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("checkfieldProfile")}}',
			data: {value: value, field: 'email'},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return false; else return true;
	} ,"Email không tồn tại");

	$.validator.setDefaults({ onkeyup: false });
	$(".reset-pass").validate({
		onfocusout: function(element) {
			this.element(element);
		},
		rules:{
			email: {
				required: true,
				email: true,
				checkemail: true
			},
			password: {
				required: true,
				minlength: 6
			},
			password_confirmation: {
				equalTo: '#password'
			}
		},
		messages:{
			email:{
				required: 'Trường này không được để trống',
				email: 'Email không đúng định dạng'
			},
			password: {
				required: 'Trường này không được để trống',
				minlength: 'Hãy nhập vào tối thiểu 6 ký tự'
			},
			password_confirmation: {
				equalTo: 'Password Confirm không đúng'
			}
		}
	});
</script>
@stop