@extends('admin::_layout.template_content')

@section('main')
<div class="box-header text-right">
	<a class="btn-success blue" href="javascript:void(0)" onclick="window.history.back()">Quay lại</a>
</div>
<div class="portlet-header">
	<h4>Sửa User</h4>
</div>
<div class="portlet-content">
	{{ Form::open(array(URL::to('/'), 'class' => 'form label-inline', 'id' => 'edit-users', 'enctype' => 'multipart/form-data'))}}
	<div class="field">
		<label for="username">Tên đăng nhập<span class="required">*</span></label>
		<input type="text" name="username" id="username" class="large" value="{{ $dataUser['username'] }}" required="">
	</div>
	<div class="field">
		<label for="fullname">Họ & Tên</label>
		<input type="text" name="fullname" id="fullname" class="large" value="{{ $dataUser['fullname'] }}" required="">
	</div>
	<div class="field">
		<label for="signature">Bút danh<span class="required">*</span></label>
		<input type="text" name="signature" id="signature" class="large" value="{{ $dataUser['signature'] }}" required="">
	</div>
	<div class="field">
		<label for="email">Email<span class="required">*</span></label>
		<input type="email" name="email" id="email" class="large" value="{{ $dataUser['email'] }}" required="">
	</div>
	<div class="field">
		<label for="datebirth">Ngày sinh</label>
		<input type="text" name="datebirth" class="large" value="{{ date('d-m-Y', $dataUser['datebirth']) }}" id="datebirth" required="">
	</div>
	<div class="field">
		<label for="department">Bộ phận làm việc</label>
		<div class="form-input">
			<select name="department" id="department" class="large">
				<option value="0">-- Chọn bộ phận làm việc --</option>
				@foreach($departments as $key => $dep)
					<option value="{{$key}}" <?php echo ($dataUser['department'] == $key)?'selected':'' ?> >{{$dep}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="field">
		<label for="placement">Vị trí làm việc</label>
		<div class="form-input">
			<textarea name="placement" class="large" id="placement">{{$dataUser['placement']}}</textarea>
		</div>
	</div>
	<div class="field">
		<label for="summary">Tóm tắt bản thân</label>
		<div class="form-input">
			<textarea name="summary" id="summary" class="large">{{$dataUser['summary']}}</textarea>
		</div>
	</div>
	<div class="field">
		<label for="avatar">Ảnh</label>

		<input type="file" name="avatar" id="avatar" class="avatar_edit"><br>
		<img src="{{ URL::to('/').'/upload/users/'.$dataUser['avatar'] }}" class="img-news">
	</div>
	<div class="field">
		<label for="check_mytour">Check In Mytour</label>
		<select name="check_mytour" class="medium" id="check_mytour">
			<option value="0" <?php echo ($dataUser['check_mytour'] == 0)?'selected':'' ?> >Không</option>
			<option value="1" <?php echo ($dataUser['check_mytour'] == 1)?'selected':'' ?> >Có</option>
		</select>
	</div>
	<div class="field">
		<label for="is_approved">Hiển thị</label>
		<select name="is_approved" class="medium" id="is_approved">
			<option value="0" <?php echo ($dataUser['is_approved'] == 1)?'selected':'' ?> >Ẩn</option>
			<option value="1" <?php echo ($dataUser['is_approved'] == 1)?'selected':'' ?> >Hiển thị</option>
		</select>
	</div>
	<input type="hidden" name="id_usr" value="{{$dataUser['id']}}" id="id_usr">
	<div class="field">
		<button type="submit" class="btn-success blue" name="btn-submit">Sửa User</button>
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
		var id_usr = $('#id_usr').val();
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("admin.checkusernameEdit")}}',
			data: {username: value, id: id_usr},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return true; else return false;
	} ,"Tên đăng nhập đã tồn tại");

	$.validator.addMethod("checkemail", function(value, element) {
		var id_usr = $('#id_usr').val();
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("admin.checkfieldEditLogin")}}',
			data: {value: value, field: 'email', id: id_usr},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return true; else return false;
	} ,"Email đã tồn tại");

	$.validator.addMethod("checkSignature", function(value, element) {
		var id_usr = $('#id_usr').val();
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("admin.checkfieldEditLogin")}}',
			data: {value: value, field: 'signature', id: id_usr},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return true; else return false;
	} ,"Bút danh đã tồn tại");

	$.validator.setDefaults({ onkeyup: false });
	$("#edit-users").validate({
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