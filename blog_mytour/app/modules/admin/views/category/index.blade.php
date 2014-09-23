@extends('admin::_layout.template_content')

@section('main')
<div class="box-header text-right">
	<a class="btn-success blue" href="{{route('cat.add')}}">Thêm</a>
	<a class="btn-success red" href="javascript:void()"
	   onClick="onDelAll(&#39;{{URL::to('/').'/admin/category/catdelete/'}}&#39;)">Xóa</a>
</div>
<div class="box-content">
	<div class="portlet-header">
		<h4>Danh mục</h4>
	</div>
	<div class="portlet-content">
		<table id="dataTable" cellpadding="0" cellspacing="0">
			<thead>
			<tr>
				<th><input type="checkbox" name="chkMasCheck"
						   onclick="onCheckAll();"/></th>
				<th>STT</th>
				<th class="col-xs-1">Tên Danh mục</th>
				<th>Danh mục cha</th>
				<th>Check Mytour</th>
				<th>Check IT</th>
				<th>Kích hoạt</th>
				<th width="10%">&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			@if($category)
				<?php $od = 1; ?>
				@foreach($category as $cat)
					<tr>
						<td><input type="checkbox" name="chk" value="{{$cat['cat_id']}}"/></td>
						<td>{{$od}}</td>
						<td><a href="{{URL::to('/').'/admin/category/catedit/'.$cat['cat_id']}}">{{ $cat['cat_name'] }}</a></td>
						<td>{{ $cat['cat_sub_name'] or 'Danh mục gốc' }}</td>
						<td id="cat_check_mytour{{$cat['cat_id']}}"><a href="javascript:void(0)" onclick="change_value_check({{$cat['cat_id'] .','. $cat['cat_check_mytour'] .','. '&#39;cat_check_mytour&#39;' . ','. $cat['cat_sub_id']}})"><img
									src="{{ URL::to('/').'/backend/assets/images/'.$cat['cat_check_mytour'].'.png' }}" style="width: 20px;"/>
									<input type="hidden" id="cat_check_mytour{{$cat['cat_id'].$cat['cat_sub_id']}}" value="{{$cat['cat_check_mytour']}}">
							</a>
						</td>
						<td id="cat_check_it{{$cat['cat_id']}}"><a href="javascript:void(0)" onclick="change_value_check({{$cat['cat_id'] .','. $cat['cat_check_it'] .','. '&#39;cat_check_it&#39;' . ','. $cat['cat_sub_id']}})"><img
									src="{{ URL::to('/').'/backend/assets/images/'.$cat['cat_check_it'].'.png' }}" style="width: 20px;"/>
									<input type="hidden" id="cat_check_it{{$cat['cat_id'].$cat['cat_sub_id']}}" value="{{$cat['cat_check_it']}}">
							</a>
						</td>
						<td id="cat_is_approved{{$cat['cat_id']}}"><a href="javascript:void(0)" onclick="change_value_check({{$cat['cat_id'] .','. $cat['cat_is_approved'] .','. '&#39;cat_is_approved&#39;' . ','. $cat['cat_sub_id']}})"><img
									src="{{URL::to('/').'/backend/assets/images/'.$cat['cat_is_approved'].'.png'}}" style="width: 20px;"/>
									<input type="hidden" id="cat_is_approved{{$cat['cat_id'].$cat['cat_sub_id']}}" value="{{$cat['cat_is_approved']}}">
							</a>
						</td>
						<td><a href="{{URL::to('/').'/admin/category/catedit/'.$cat['cat_id']}}">Edit</a> | <a href="javascript:void(0)" onclick="if (confirm('Bạn có muốn xóa không?')) {window.location.href=&#39;{{URL::to('/').'/admin/category/catdelete/'.$cat['cat_id']}}&#39;}">Delete</a></td>
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
<script>
	function change_value_check(id, val, col, cat_sub_id){
		/* Send the data using post and put the results in a div */
		if(col == 'cat_check_mytour' || col == 'cat_check_it'){
			if(cat_sub_id != 0){
				var check_change = $("#"+col+cat_sub_id+0).val();
				if(check_change == 1){
					alert('Bạn không được thay đổi giá trị này');
					return false;
				}
			}
		}else if(col == 'cat_is_approved'){
			if(cat_sub_id != 0){
				var check_change = $("#"+col+cat_sub_id+0).val();
				if(check_change == 0){
					alert('Bạn không được thay đổi giá trị này');
					return false;
				}
			}
		}
		$.ajax({
			url: "{{  route('cat.active') }}",
			type: "GET",
			data: {id: id, val: val, col: col, cat_sub_id: cat_sub_id},
			success: function(html){
				var html_arr = jQuery.parseJSON(html);
					if(typeof(html_arr) != "undefined"){
						for(var cat in html_arr){
							$("#"+col+html_arr[cat].cat_id).html(html_arr[cat].html);
							if(typeof(html_arr[cat].cat_id) != "undefined"){
								$("#"+col+html_arr[cat].cat_id).html(html_arr[cat].html);
							}
						}
					}
			},
			error:function(){
				$("#"+col+id).html('Lỗi, bạn hãy thử lại');
			}
		});
	}
</script>
@endsection
