@extends('content::_layout.default')
@section('header_blogger')
<div class="blog_header">
	<div class="blog_header_top">
		<div class="nav">
			<a href="#" class="on">Blogger</a>
		</div>
		<div class="button_like_google">
			<span class='st_googleplus_hcount' displayText='Google +'></span>
		</div>
		<div class="button_like_tweet">
			<span class='st_twitter_hcount' displayText='Tweet'></span>
		</div>
		<div class="button_like_face">
			<span class='st_facebook_hcount' displayText='Facebook'></span>
		</div>
		<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
		<script type="text/javascript">stLight.options({publisher: "994e439b-6966-4dd4-8ef9-fd647616d111", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
		<div class="clrb"></div>
	</div>
	<div class="cover">
		<img alt="cover_photo" src="{{URL::to('/').'/assets/images/cover_photo.jpg'}}">
	</div>
	<div class="header_bot">
		@if($dataUser)
			@foreach($dataUser as $user)
				<div class="user">
					<a href="{{URL::to('/').'/blogger/profile/'.$user['signature']}}" class="ava">
						<img alt="avatar" src="{{URL::to('/').'/upload/users/'.$user['avatar']}}" title="{{$user['signature']}}" width="100px" height="100px">
					</a>
					<div class="if">
						<a href="{{URL::to('/').'/blogger/profile/'.$user['username']}}" class="name">{{$user['signature']}}</a>
						<p>Họ & Tên: {{$user['fullname']}}</p>
						<p class="date">Ngày sinh: {{date('d/m/Y', $user['datebirth'])}}</p>
						<p class="posts">{{$user['count_article']}} bài viết</p>
					</div>
					<div class="clrb"></div>
				</div>
				<div class="follow_box">
					<p>Ngày tham gia</p>
					<span>{{date('d/m/Y', strtotime($user['created_at']))}}</span>
					<p>Follow me on</p>
					<a href="F#" class="ico_facebook"></a>
					<a href="#" class="ico_youtube"></a>
					<a href="#" class="ico_linkedin"></a>
					<a href="#" class="ico_twitter"></a>
				</div>
			@endforeach
		@endif
	</div>
</div>
@stop
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