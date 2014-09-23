@extends('admin::_layout.template_login')

@section('main')
<div id="login-body" class="clearfix">
	{{ Form::open(array('route' => 'usr.remind.post', 'id' => 'remind-pass')) }}

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
				{{Form::label('email', 'Email')}}

				<div class="">
					<span class="input">
						{{Form::text('email', null, array('class' => 'text', 'placeholder' => 'E-mail'))}}
					</span>
				</div>
			</div>
			<!-- .field -->

			<div class="field">
				<span class="label">&nbsp;</span>

				<div class="">
					{{Form::button('Gửi', array('type' => 'submit', 'class' => 'btn-success blue'))}}
				</div>
			</div>
			<!-- .field -->
		</div>
	</div>
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
	$("#remind-pass").validate({
		onfocusout: function(element) {
			this.element(element);
		},
		rules:{
			email: {
				required: true,
				email: true,
				checkemail: true
			}
		},
		messages:{
			email:{
				required: 'Trường này không được để trống',
				email: 'Email không đúng định dạng'
			}
		}
	});
</script>
@stop