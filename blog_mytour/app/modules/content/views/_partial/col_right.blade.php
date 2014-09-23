
	<div class="inf-blog">
		<p class="slogan-right">Cùng chúng tôi</p>
		<div class="clrb"></div>
		<div class="box-content">
			@if($dataBlogger)
			<ul>
				@foreach($dataBlogger as $blogger)
					<li class="ava-user"><a href="{{URL::to('/').'/blogger/profile/'.$blogger['signature']}}"><img src="{{URL::to('/').'/upload/users/'.$blogger['avatar']}}"></a></li>
				@endforeach
			</ul>
			@endif
		</div>
		<div class="clrb"></div>
		<p class="slogan-right text-right">Viết bài <span class="icon-slogan">&</span> chia sẻ</p>
	</div>

	<!-- BOX blog -->
	<div class="events_box">
		<div class="events_box_hd"><h2>Blog mới</h2></div>
		@if($dataBlogNew)
		<ol>
			@for($i = 0; $i < count($dataBlogNew ); $i++)
			<li>
				<a href ="{{URL::to('/').'/bai-viet/'.$dataBlogNew[$i]['art_id'].'-'.$dataBlogNew[$i]['art_seo_title'].'.html'}}">
					<span aria-hidden="true" class="number">{{$i+1}}</span>{{$dataBlogNew[$i]['art_title']}}
				</a>
			</li>
			@endfor
		@endif
		</ol>
	</div>
	<!-- END BOX blog -->
