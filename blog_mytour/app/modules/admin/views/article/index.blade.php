@extends('admin::_layout.template_content')

@section('main')
<div class="box-header text-right">
	<a class="btn-success blue" href="{{route('art.add')}}">Thêm</a>
	<a class="btn-success red" href="javascript:void()"
	   onClick="onDelAll(&#39;{{URL::to('/').'/admin/article/artdelete/'}}&#39;)">Xóa</a>

</div>
<div class="box-content">
	<div class="portlet-header">
		<h4>Bài viết</h4>
	</div>
	<div class="portlet-content">
		<div class="alert">{{$alert or ''}}</div>
		<table id="dataTable" cellpadding="0" cellspacing="0">
			<thead>
			<tr>
				<th><input type="checkbox" name="chkMasCheck"
						   onclick="onCheckAll();"/></th>
				<th>STT</th>
				<th class="col-xs-1">Tiêu đề Bài viết</th>
				<th>Danh mục</th>
				<th>Người đăng bài</th>
				<th>Thời gian</th>
				<th>Kích hoạt</th>
				<th width="10%">&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			@if($dataArt)
				<?php $od = 1; ?>
				@foreach($dataArt as $art)
					<tr>
						<td><input type="checkbox" name="chk" value="{{ $art['art_id'] }}"/></td>
						<td>{{$od}}</td>
						<td><a href="{{ URL::to('/').'/admin/article/artedit/'.$art['art_id'] }}">{{ $art['art_title'] }}</a></td>
						<td>{{ $art['cat_name'] or 'Không có' }}</td>
						<td>{{ $art['username'] }}</td>
						<td>{{ date('d-m-Y H:i:s', $art['art_date_created']) }}</td>
						<td><a id="hot{{$od}}"
							   href="javascript:void(0)"><img
									src="{{ URL::to('/').'/backend/assets/images/'.$art['art_is_approved'].'.png' }}" style="width: 20px;"/>
								<input type="hidden" value="{{$art['art_is_approved']}}" id="art_is_approved{{$od}}">
							</a>
							<script>
								$('#hot{{ $od; }}').click(function(){
									/* Send the data using post and put the results in a div */
									var hot = $("#art_is_approved{{ $od }}").val();
									$.ajax({
										url: "{{  route('admin.active') }}",
										type: "GET",
										data: {id: {{  $art['art_id'] }}, ih: hot, hot: {{  $od }}, tbl: 'article', col: 'art_is_approved', iw: 'art_id'},
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
						<td><a href="{{URL::to('/').'/admin/article/artedit/'.$art['art_id']}}">Edit</a> | <a href="javascript:void(0)" onclick="if (confirm('Bạn có muốn xóa không?')) {window.location.href=&#39;{{URL::to('/').'/admin/article/artdelete/'.$art['art_id']}}&#39;}">Delete</a></td>
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
