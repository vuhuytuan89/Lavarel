@extends('admin::_layout.template_content')

@section('main')
<div class="box-header text-right">
	<a class="btn-success red" href="javascript:void()"
	   onClick="onDelAll(&#39;{{URL::to('/').'/admin/comment/comdelete/'}}&#39;)">Xóa</a>

</div>
<!-- {{ HTML::style('backend/assets/css/jquery.dataTables.min.css') }} -->
<!-- {{ HTML::script('backend/assets/js/jquery.dataTables.min.js') }} -->
<div class="box-content">
	<div class="portlet-header">
		<h4>Bình luận</h4>
	</div>
	<div class="portlet-content">
		<div class="alert">{{$alert or ''}}</div>
		<table id="dataTable" cellpadding="0" cellspacing="0">
			<thead>
			<tr>
				<th><input type="checkbox" name="chkMasCheck"
						   onclick="onCheckAll();"/></th>
				<th>STT</th>
				<th>ID</th>
				<th>Bài viết</th>
				<th>Người Bình luận</th>
				<th>Nội dung</th>
				<th>Thời gian</th>
				<th>Kích hoạt</th>
				<th width="10%">&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			@if($dataCom)
				<?php $od = 1; ?>
				@foreach($dataCom as $com)
					<tr>
						<td><input type="checkbox" name="chk" value="{{ $com['com_id'] }}"/></td>
						<td>{{$od}}</td>
						<td>{{ $com['art_title'] or 'Không có' }}</td>
						<td>{{ $com['username'] }}</td>
						<td style="width: 250px; height: 80px; overflow: auto">{{ $com['com_detail'] }}</td>
						<td>{{ date('d-m-Y H:i:s', $com['com_date_created']) }}</td>
						<td><a id="hot{{$od}}"
							   href="javascript:void(0)"><img
									src="{{ URL::to('/').'/backend/assets/images/'.$com['com_is_approved'].'.png' }}" style="width: 20px;"/>
								<input type="hidden" value="{{$com['com_is_approved']}}" id="com_is_approved{{$od}}">
							</a>
							<script>
								$('#hot{{ $od; }}').click(function(){
									/* Send the data using post and put the results in a div */
									var hot = $("#com_is_approved{{ $od }}").val();
									$.ajax({
										url: "{{  route('admin.active') }}",
										type: "GET",
										data: {id: {{  $com['com_id'] }}, ih: hot, hot: {{  $od }}, tbl: 'comment', col: 'com_is_approved', iw: 'com_id'},
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
						<td><a onclick="if (confirm('Bạn có muốn xóa không?')) {window.location.href=&#39;{{URL::to('/').'/admin/comment/comdelete/'.$com['com_id']}}&#39;}" href="javascript:void(0)">Delete</a></td>
					</tr>
					<?php $od++; ?>
				@endforeach
			@endif
			</tbody>
		</table>
		<div class="paging">
			{{$dataPaging->links()}}
		</div>
	</div>
</div>
<!--
<script>
	$(document).ready(function() {
	$('#dataTable').dataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": "{{URL::to('/admin/comment/loadDatatable')}}",
		"columnDefs": [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
                    return  '<img src="data">';
                },
                "targets": 7
            },
            { "visible": false,  "targets": [ 2 ] }
        ]
	} );
} );
</script>
 -->
@endsection
