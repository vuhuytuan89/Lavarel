@extends('admin::_layout.template_content')

@section('main')
<div class="box-header text-right">
	<a class="btn-success blue" href="{{route('usr.add')}}">Thêm</a>
	<a class="btn-success red" href="javascript:void()"
	   onClick="onDelAll(&#39;{{URL::to('/').'/admin/user/usrdelete/'}}&#39;)">Xóa</a>

</div>
<div class="box-content">
	<div class="portlet-header">
		<h4>User</h4>
	</div>
	<div class="portlet-content">
		@if (Session::has('success'))
			<div id="alert_success"><label>{{ Session::get('success') }}</label></div>
		@endif
		<table id="dataTable" cellpadding="0" cellspacing="0">
			<thead>
			<tr>
				<th><input type="checkbox" name="chkMasCheck"
						   onclick="onCheckAll();"/></th>
				<th>STT</th>
				<th>Tên đăng nhập</th>
				<th>Họ & Tên</th>
				<th>Bút danh</th>
				<th>Email</th>
				<th>Ngày sinh</th>
				<th>avatar</th>
				<th>Check Mytour</th>
				<th>Kích hoạt</th>
				<th width="150px">&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			@if($dataUser)
				<?php $od = 1;?>
				@foreach($dataUser as $usr)
					<tr>
						<td><input type="checkbox" name="chk" value="{{ $usr['id'] }}"/></td>
						<td>{{$od}}</td>
						<td><a href="{{URL::to('/').'/admin/user/usredit/'.$usr['id']}}">{{$usr['username']}}</a></td>
						<td>{{$usr['fullname']}}</td>
						<td>{{$usr['signature']}}</td>
						<td>{{$usr['email']}}</td>
						<td>{{ date('d-m-Y', $usr['datebirth']) }}</td>
						<td><img style="width: 80px" src="{{ URL::to('/').'/upload/users/'.$usr['avatar'] }}"> </td>
						<td><a id="checkmytour{{$od}}"
							   href="javascript:void(0)"><img
									src="{{ URL::to('/').'/backend/assets/images/'.$usr['check_mytour'].'.png' }}" style="width: 20px;"/>
								<input type="hidden" value="{{$usr['check_mytour']}}" id="check_mytour{{$od}}">
							</a>
							<script>
								$('#checkmytour{{ $od; }}').click(function(){
									/* Send the data using post and put the results in a div */
									var hot = $("#check_mytour{{ $od }}").val();
									$.ajax({
										url: "{{  route('admin.active') }}",
										type: "GET",
										data: {id: {{  $usr['id'] }}, ih: hot, hot: {{  $od }}, tbl: 'users', col: 'check_mytour', iw: 'id'},
										success: function(html){
												$("#checkmytour{{  $od }}").html(html);
										},
										error:function(){
											$("#checkmytour{{  $od }}").html('Lỗi, bạn hãy thử lại');
										}
									});
								});
							</script>
						</td>
						<td><a id="hot{{$od}}"
							   href="javascript:void(0)"><img
									src="{{ URL::to('/').'/backend/assets/images/'.$usr['is_approved'].'.png' }}" style="width: 20px;"/>
								<input type="hidden" value="{{$usr['is_approved']}}" id="is_approved{{$od}}">
							</a>
							<script>
								$('#hot{{ $od; }}').click(function(){
									/* Send the data using post and put the results in a div */
									var hot = $("#is_approved{{ $od }}").val();
									$.ajax({
										url: "{{  route('admin.active') }}",
										type: "GET",
										data: {id: {{  $usr['id'] }}, ih: hot, hot: {{  $od }}, tbl: 'users', col: 'is_approved', iw: 'id'},
										success: function(html){
												$("#hot{{  $od }}").html(html);
										},
										error:function(){
											$("#hot{{  $od }}").html('Lỗi, bạn hãy thử lại');
										}
									});
								});
							</script>
						</td>
						<td><a href="{{URL::to('/').'/admin/user/usredit/'.$usr['id']}}">Edit</a> | <a href="{{URL::to('/').'/admin/user/thay-doi-mat-khau/'.$usr['id']}}">Đổi mật khẩu</a> | <a onclick="if (confirm('Bạn có muốn xóa không?')) {window.location.href=&#39;{{URL::to('/').'/admin/user/usrdelete/'.$usr['id']}}&#39;}"  href="javascript:void(0)">Delete</a></td>
					</tr>
					<?php $od++; ?>
				@endforeach
			@endif
			</tbody>
		</table>
		<div class="paging">
			{{ $dataPaging->links() }}
		</div>
	</div>
</div>
@endsection
