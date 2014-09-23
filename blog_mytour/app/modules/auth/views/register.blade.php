@extends('content::_layout.default')

@section('main')
{{ HTML::style('backend/assets/css/jquery.datetimepicker.css') }}
{{ HTML::script('backend/assets/js/jquery.datetimepicker.js') }}
{{ HTML::script('backend/assets/js/jquery.validate.min.js') }}
<div class="reg_form">
	<h1>Đăng ký</h1>
	{{Form::open(array('route' => 'register.post', 'name' => 'register', 'class' => 'register-form', 'enctype' => 'multipart/form-data'))}}
		<ul>
			<li>
				<label>Tên đăng nhập</label>
				<div><input type="text" name="username" class="txt" placeholder="Tên đăng nhập" value=""></div>
			</li>
			<li>
				<label>Họ và tên</label>
				<div><input type="text" name="fullname" class="txt" placeholder="Họ và tên" value=""></div>
			</li>
			<li>
				<label>Email</label>
				<div><input type="text" name="email" class="txt" placeholder="email" value=""></div>
			</li>
			<li>
				<label>Ngày sinh</label>
				<div><input type="text" name="datebirth" id="datebirth" class="txt" placeholder="Ngày sinh" value=""></div>
			</li>
			<li>
				<label>Mật khẩu</label>
				<div><input type="password" name="password" class="txt" placeholder="mật khẩu"></div>
			</li>
			<li>
				<label>Avatar</label>
				<div><input type="file" name="avatar" class="txt" placeholder="avatar"></div>
			</li>
			<li class="button">
				<a href="{{route('login')}}" class="acc">Bạn đã có tài khoản?</a>
				<input type="submit" name="register-submit" class="btn_blue" value="đăng ký">
				<div class="clrb"></div>
			</li>
			<li><a href="{{route('remindpass')}}" class="forgot">Quên mật khẩu?</a></li>
		</ul>
	{{Form::close()}}
</div>
<script>
	$("#datebirth").datetimepicker({
		lang:'vn',
		i18n:{
			vn:{
				months:[
					'Tháng 1','Tháng 2','Tháng 3','Tháng 4',
					'Tháng 5','Tháng 6','Tháng 7','Tháng 8',
					'Tháng 9','Tháng 10','Tháng 11','Tháng 12',
				],
				dayOfWeek:[
					"CN", "T2", "T3", "T4",
					"T5", "T6", "T7",
				]
			}
		},
		format:'d-m-Y',
		timepicker: false
	});
</script>
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
		if(result .responseText == 0) return true; else return false;
	} ,"Tên đăng nhập đã tồn tại");

	$.validator.addMethod("checkemail", function(value, element) {
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("checkemail")}}',
			data: {email: value},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return true; else return false;
	} ,"Email đã tồn tại");

	$.validator.setDefaults({ onkeyup: false });
	$(".register-form").validate({
		onfocusout: function(element) {
			this.element(element);
		},
		rules:{
			username: {
				required: true,
				checkusername: true
			},
			email: {
				required: true,
				checkemail: true,
				email: true
			},
			password: {
				required: true,
				minlength: 6
			}
		},
		messages:{
			username:{
				required: 'Trường này không được để trống'
			},
			email: {
				required: 'Trường này không được để trống',
				email: 'Email không đúng định dạng'
			},
			password: {
				required: 'Trường này không được để trống',
				minlength: 'Hãy nhập vào tối thiểu 6 ký tự'
			}
		}
	});
</script>
@stop