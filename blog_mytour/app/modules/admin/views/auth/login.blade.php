@extends('admin::_layout.template_login')
@section('main')
<h1 id="title"><a href="#">Carbon Admin</a></h1>
<div id="login-body" class="clearfix">
	{{ Form::open(array('route' => 'admin.login.post', 'id' => 'formlogin')) }}

	<!-- check for login error flash var -->
	@if (Session::has('error'))
		<div id="alert_error"><label>{{ Session::get('error') }}</label></div>
	@endif
	@if (Session::has('success'))
		<div id="alert_success"><label>{{ Session::get('success') }}</label></div>
	@endif

	<div class="content_front">
		<div class="pad">

			<div class="field">
				{{Form::label('username', 'Username')}}

				<div class="">
					<span class="input">
						{{Form::text('username', null, array('class' => 'text', 'placeholder' => 'User name'))}}
					</span>
				</div>
			</div>
			<!-- .field -->

			<div class="field">
				{{Form::label('password', 'Password')}}

				<div class=""><span class="input">
						{{Form::password('password', array('class' => 'text', 'placeholder' => 'password'))}}
						<a href="{{ Route('usr.remind') }}" id="forgot_my_password">Forgot password?</a></span></div>
			</div>
			<!-- .field -->

			<div class="field">
				<span class="label">&nbsp;</span>

				<div class="">
					{{Form::button('Login', array('type' => 'submit', 'class' => 'btn-success blue'))}}
				</div>
			</div>
			<!-- .field -->
		</div>
	</div>
	{{ Form::close() }}
</div>
<script>
	$.validator.addMethod("checkusername", function(value, element) {
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("admin.ajaxusernamelogin")}}',
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
			url: '{{route("admin.ajaxpasslogin")}}',
			data: {password: value, username: username},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return false; else return true;
	} ,"Mật khẩu không đúng");

	$.validator.setDefaults({ onkeyup: false });
	$("#formlogin").validate({
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
				minlength: 6,
				checkpass: true
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
@endsection
