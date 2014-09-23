@extends('content::_layout.default')

@section('main')
		<div class="content_profile">
			<div class="box-heading"><h3>Profile</h3></div>
				<?php echo (Session::get('success'))?'<div class="alert-success"><label>' . Session::get('success') . '</label></div>':''; ?>
			{{Form::open(array('route' => 'profile.post', 'class' => 'profile_usr', 'enctype' => 'multipart/form-data'))}}
			<div class="field">
				<label for="signature">Bút danh<span class="required">*</span></label>
				<div class="form-input">
					<input type="text" name="signature" id="signature" value="{{$dataUser['signature']}}">
				</div>
			</div>
			<div class="field">
				<label for="fullname">Họ và tên</label>
				<div class="form-input">
					<input type="text" name="fullname" id="fullname" value="{{$dataUser['fullname']}}">
				</div>
			</div>
			<div class="field">
				<label for="email">Email</label>
				<div class="form-input">
					<input type="email" name="email" id="email" value="{{$dataUser['email']}}">
				</div>
			</div>
			<div class="field">
				<label for="datebirth">Ngày sinh</label>
				<div class="form-input">
					<input type="text" name="datebirth" id="datebirth" value="{{date('d-m-Y', $dataUser['datebirth'])}}">
				</div>
			</div>
			<div class="field">
				<label for="placement">Vị trí làm việc</label>
				<div class="form-input">
					<textarea name="placement" id="placement">{{$dataUser['placement']}}</textarea>
				</div>
			</div>
			<div class="field">
				<label for="summary">Tóm tắt bản thân</label>
				<div class="form-input">
					<textarea name="summary" id="summary">{{$dataUser['summary']}}</textarea>
				</div>
			</div>
			<div class="field">
				<label for="avatar">Avatar</label>
				<div class="form-input">
					<input type="file" name="avatar" id="avatar" class="avatar">
					<img class='avatar' src="{{URL::to('/upload/users/').'/'.$dataUser['avatar']}}">
				</div>
			</div>
			<div class="field text-right">
				<div>
					<button type="submit" class="btn_blue">Cập nhật</button>
				</div>
			</div>
			{{Form::close()}}
		</div>
	{{ HTML::style('backend/assets/css/jquery.datetimepicker.css') }}
	{{ HTML::script('backend/assets/js/jquery.datetimepicker.js') }}
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
	$.validator.addMethod("checkemail", function(value, element) {
		var result = $.ajax({
			async:false,
			type: "POST",
			url: '{{route("checkfieldProfile")}}',
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
			url: '{{route("checkfieldProfile")}}',
			data: {value: value, field: 'signature'},
			dataType: "text"
		});
		console.log(result .responseText);
		if(result .responseText == 0) return true; else return false;
	} ,"Bút danh đã tồn tại");

	$.validator.setDefaults({ onkeyup: false });
	$(".profile_usr").validate({
		onfocusout: function(element) {
			this.element(element);
		},
		rules:{
			signature:{
					required: true,
					checkSignature: true
			},
			email: {
				required: true,
				checkemail: true,
				email: true
			}
		},
		messages:{
			signature: {
				required: 'Trường này không được để trống'
			},
			email: {
				required: 'Trường này không được để trống',
				email: 'Email không đúng định dạng'
			}
		}
	});
</script>
@stop