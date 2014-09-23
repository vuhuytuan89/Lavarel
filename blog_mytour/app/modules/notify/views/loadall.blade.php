@extends('content::_layout.default')

@section('main')
@if($dataNotify)
	<div class="notify-all">
		<ul class="media-list msg-list">
			@foreach($dataNotify as $notify)
			<li class="media">
				<a class="fleft" href="{{URL::to('/').'blogger/'.$notify['signature']}}">
					<img class="img-notify" src="{{URL::to('/').'/upload/users/'.$notify['avatar']}}" alt="..."> </a>
				<div class="media-body">
					<div class="fright media-option">
						<small>{{$notify['date_created']}}</small>
					</div>
					<h4 class="sender">{{$notify['signature']}} @if($notify['not_type'] == 1) đã bình luận về 1 bài viết của bạn @endif @if($notify['not_type'] == 2) đã trích dẫn 1 bình luận của bạn @endif</h4>
					<div><a href="{{URL::to('/').'/bai-viet/'.$notify['not_art_id'].'-'.$notify['art_seo_title'].'.html#comments'}}">{{$notify['com_detail']}}</a></div>
				</div>
			</li>
			@endforeach
		</ul>
		<div class="pagging">
			{{$dataPaging->links()}}
		</div>
	</div>
@else
<div class='alert-error text-center'><label>Bạn không có thông báo nào</label></div>
@endif
@stop
