@extends('content::_layout.default')

@section('main')
	@if(isset($article))
	<ul class="list_news">
		@foreach($article['data'] as $art)
		<li class="news_big">
			<div class="news_right">
				<div class="top">
					<h3><a href="{{URL::to('/').'/bai-viet/'.$art['art_id'].'-'.$art['art_seo_title'].'.html'}}" class="title">{{$art['art_title']}}</a></h3>
				</div>
				<div class="article">
					<div class="text">
						<p class="time">
							<a href="{{URL::to('/').'/blogger/profile/'.$art['signature']}}" class="username"><img src="{{URL::to('/').'/upload/users/'.$art['avatar']}}" alt=""><span>{{$art['signature']}}</a></span><span class="separator"> | </span>
							<span><a href ="{{URL::to('/').'/danh-muc/'.$art['cat_id'].'-'.$art['cat_seo_name'].'.html'}}">{{$art['cat_name']}}</a></span>
							<span class="fright">{{date('d/m/Y', $art['art_date_created'])}}  {{date('H:i', $art['art_date_created'] )}} - {{$art['count_com'] .' comments'}}</span>
						</p>
						<p>{{$art['art_shortdetail']}}</p>
					</div>
					<div class="clrb"></div>
				</div>
			</div>
		</li>
		@endforeach
	</ul>

	@endif
	<div class="pagging">
		{{ $article_paging->links() }}
	</div>
@stop
