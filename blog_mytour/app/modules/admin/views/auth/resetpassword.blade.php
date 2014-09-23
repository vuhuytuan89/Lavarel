@extends('admin::_layout.template_login')

@section('main')
<div id="login-body" class="clearfix">
	{{ Form::open(array('route' => 'usr.reset.post', 'id' => 'reset-pass')) }}

	<!-- check for login error flash var -->
	@if (Session::has('error'))
	<div id="alert_error">{{ Session::get('error') }}</div>
	@endif
	@if (Session::has('success'))
	<div id="alert_success">{{ Session::get('success') }}</div>
	@endif

	<div class="content_front">
		<div class="pad">

			<div class="field">
				{{Form::label('email', 'Email')}}

				<div class="">
					<span class="input">
						{{Form::text('email', null, array('class' => 'text', 'placeholder' => 'E-mail'))}}
					</span>
				</div>
			</div>
			<!-- .field -->

			<div class="field">
				{{Form::label('password', 'Password')}}

				<div class="">
					<span class="input">
						{{Form::password('password', array('class' => 'text', 'placeholder' => 'Password'))}}
					</span>
				</div>
			</div>
			<!-- .field -->

			<div class="field">
				{{Form::label('password_confirmation', 'Password Confirm')}}

				<div class="">
					<span class="input">
						{{Form::password('password_confirmation', array('class' => 'text', 'placeholder' => 'Password Confirm'))}}
					</span>
				</div>
			</div>
			<!-- .field -->

			<div class="field">
				<span class="label">&nbsp;</span>

				<div class="">
					{{Form::button('Đổi mật khẩu', array('type' => 'submit', 'class' => 'btn-success blue'))}}
				</div>
			</div>
			<!-- .field -->
		</div>
	</div>
	{{ Form::hidden('token', $token) }}
	{{ Form::close() }}
</div>
<script>
	$.validator.addMethod("checkemail", function(value, element) {
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("admin.CheckEmail")}}',
			data: {email: value},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return false; else return true;
	} ,"Email không tồn tại");

	$.validator.setDefaults({ onkeyup: false });
	$("#reset-pass").validate({
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