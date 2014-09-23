@extends('admin::_layout.template_content')

@section('main')
<div class="box-header text-right">
	<a class="btn-success blue" href="{{route('admin.add')}}">Thêm</a>
	<a class="btn-success red" href="javascript:void()"
	   onClick="onDelAll(&#39;{{URL::to('/').'/admin/admdelete/'}}&#39;)">Xóa</a>

</div>
<div class="box-content">
	<div class="portlet-header">
		<h4>Admin</h4>
	</div>
	<div class="portlet-content">
		<div class="alert">{{$alert or ''}}</div>
		<table id="dataTable" cellpadding="0" cellspacing="0">
			<thead>
			<tr>
				<th><input type="checkbox" name="chkMasCheck"
						   onclick="onCheckAll();"/></th>
				<th>STT</th>
				<th>Tên đăng nhập</th>
				<th>Họ & Tên</th>
				<th>Email</th>
				<th>Ngày sinh</th>
				<th>avatar</th>
				<th>Kích hoạt</th>
				<th width="10%">&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			@if($dataAdmin)
				<?php $od = 1;?>
				@foreach($dataAdmin as $adm)
					<tr>
						<td><input type="checkbox" name="chk" value="{{ $adm['id'] }}"/></td>
						<td>{{$od}}</td>
						<td><a href="{{URL::to('/').'/admin/admedit/'.$adm['id']}}">{{$adm['username']}}</a></td>
						<td>{{$adm['fullname']}}</td>
						<td>{{$adm['email']}}</td>
						<td>{{ date('d-m-Y', $adm['datebirth']) }}</td>
						<td><img style="width: 80px" src="{{ URL::to('/').'/upload/users/'.$adm['avatar'] }}"> </td>
						<td><a id="hot{{$od}}"
							   href="javascript:void(0)"><img
									src="{{ URL::to('/').'/backend/assets/images/'.$adm['is_approved'].'.png' }}" style="width: 20px;"/>
								<input type="hidden" value="{{$adm['is_approved']}}" id="is_approved{{$od}}">
							</a>
							<script>
								$('#hot{{ $od; }}').click(function(){
									/* Send the data using post and put the results in a div */
									var hot = $("#is_approved{{ $od }}").val();
									$.ajax({
										url: "{{  route('admin.active') }}",
										type: "GET",
										data: {id: {{  $adm['id'] }}, ih: hot, hot: {{  $od }}, tbl: 'users', col: 'is_approved', iw: 'id'},
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
						<td><a href="{{URL::to('/').'/admin/admedit/'.$adm['id']}}">Edit</a> | <a onclick="if (confirm('Bạn có muốn xóa không?')) {window.location.href=&#39;{{URL::to('/').'/admin/admdelete/'.$adm['id']}}&#39;}"  href="javascript:void(0)">Delete</a></td>
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
