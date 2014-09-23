@extends('admin::_layout.template_content')

@section('main')
<div class="box-header text-right">
	<a class="btn-success blue" href="javascript:void(0)" onclick="window.history.back()">Quay lại</a>
</div>
<div class="portlet-header">
	<h4>Thêm User</h4>
</div>
<div class="portlet-content">
	{{ Form::open(array('route' => 'usr.add', 'class' => 'form label-inline', 'id' => 'add-users', 'enctype' => 'multipart/form-data'))}}
	<div class="field">
		<label for="username">Tên đăng nhập<span class="required">*</span></label>
		<input type="text" name="username" class="large" id="username" required="">
	</div>
	<div class="field">
		<label for="fullname">Họ & Tên</label>
		<input type="text" name="fullname" class="large" id="fullname">
	</div>
	<div class="field">
		<label for="signature">Bút danh<span class="required">*</span></label>
		<input type="text" name="signature" class="large" id="signature">
	</div>
	<div class="field">
		<label for="email">Email<span class="required">*</span></label>
		<input type="email" name="email" id="email" class="large" required="">
	</div>
	<div class="field">
		<label for="password">Mật khẩu<span class="required">*</span></label>
		<input type="password" name="password" id="password" class="large" required="">
	</div>
	<div class="field">
		<label for="datebirth">Ngày sinh</label>
		<input type="text" name="datebirth" id="datebirth" class="medium">
	</div>
	<div class="field">
		<label for="department">Bộ phận làm việc</label>
		<div class="form-input">
			<select name="department" id="department" class="large">
				<option value="0">-- Chọn bộ phận làm việc --</option>
				@foreach($departments as $key => $dep)
					<option value="{{$key}}">{{$dep}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="field">
		<label for="placement">Vị trí làm việc</label>
		<div class="form-input">
			<textarea name="placement" id="placement" class="large"></textarea>
		</div>
	</div>
	<div class="field">
		<label for="summary">Tóm tắt bản thân</label>
		<div class="form-input">
			<textarea name="summary" class="large" id="summary"></textarea>
		</div>
	</div>
	<div class="field">
		<label for="avatar">Avatar</label>

		<input type="file" name="avatar" id="avatar">
	</div>
	<div class="field">
		<label for="check_mytour">Check In Mytour</label>
		<select name="check_mytour" class="medium" id="check_mytour">
			<option value="0">Không</option>
			<option value="1" selected >Có</option>
		</select>
	</div>
	<div class="field">
		<label for="is_approved">Hiển thị</label>
		<select name="is_approved" class="medium" id="is_approved">
			<option value="0">Ẩn</option>
			<option value="1" selected>Hiển thị</option>
		</select>
	</div>
	<div class="field">
		<button type="submit" class="btn-success blue" name="btn-submit">Thêm User</button>
		<button type="reset" class="btn-success red" name="btn-reset">Reset</button>
	</div>
	{{ Form::close() }}
</div>
{{ HTML::script('backend/assets/js/jquery.validate.min.js') }}
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
			url: '{{route("checkfield")}}',
			data: {value: value, field: 'email'},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return true; else return false;
	} ,"Email đã tồn tại");

	$.validator.addMethod("checkSignature", function(value, element) {
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("checkfield")}}',
			data: {value: value, field: 'signature'},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return true; else return false;
	} ,"Bút danh đã tồn tại");

	$.validator.setDefaults({ onkeyup: false });
	$("#add-users").validate({
		errorElement: 'span',
		onfocusout: function(element) {
			this.element(element);
		},
		rules:{
			username: {
				required: true,
				checkusername: true
			},
			signature: {
				required: true,
				checkSignature: true
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
			signature: {
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