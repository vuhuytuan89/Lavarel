<div class="menu_top">
	<div class="menu_top_main">
		<div class="menu_top_ct">
			<a href="{{route('home')}}" class="logo"></a>
			<div class="navbar">
				<ul>
					@if(!empty($dataMenu))
						@foreach($dataMenu as $menu)
							<li>
								<a href="{{URL::to('/').'/danh-muc/'.$menu['cat_id'].'-'.$menu['cat_seo_name'].'.html'}}" target="_self"><span <?php if(isset($menu['dataSubMenu'])) echo 'class="arrow"'; ?> >{{$menu['cat_name']}}</span></a>
								@if(isset($menu['dataSubMenu']))
									<ul class="sub_nav">
											@foreach($menu['dataSubMenu'] as $submenu)
												<li>
													<a href="{{URL::to('/').'/danh-muc/'.$submenu['cat_id'].'-'.$submenu['cat_sub_seo_name'].'.html'}}" target="_self">{{$submenu['cat_name']}}</a>
												</li>
											@endforeach
									</ul>
								@endif
							</li>
						@endforeach
					@endif
					@if(Session::get('infusr_id'))
						<li><a href="{{ URL::to('/dang-bai.html') }}"><span><b>+ Đăng bài</b></span></a></li>
					@endif
				</ul>
				<div class="clrb"></div>
			</div>
			<div class="right_box">
				@if(!Session::get('infusr'))
					<div class="before_login">
						<a href="{{route('login')}}">Đăng nhập</a>
					</div>
				@endif
				@if(Session::get('infusr'))
				<div class="after_login">
					<a href="{{URL::to('/').'/blogger/profile/'. $dataUserLogin['signature']}}" class="fleft usr_name">{{$dataUserLogin['signature']}}</a>
					<ul class="sub_nav">
						<li><a href="{{URL::to('/').'/blogger/sua-profile.html'}}">Thay đổi Profile</a></li>
						<li><a href="{{URL::to('/').'/blogger/quan-ly-bai-viet.html'}}">Quản lý Bài viết</a></li>
						<li><a href="{{route('usr.resetpass')}}">Đổi mật khẩu</a></li>
					</ul>
					<div id="notify" class="fleft">
						<button type="button" class="btn-notify">
							<span class="count-notify">{{$countNotify or '0'}}</span>
							<input type="hidden" name="count_click_notify" value="0" id="count_click_notify">
						</button>
						<div class="content-notify">
							<h5>Thông báo</h5>
							<ul class="media-list dropdown-list">
								@if($dataNotify_header)
									@foreach($dataNotify_header as $notify)
										<li>
											<img class="img-notify" src="{{URL::to('/').'/upload/users/'.$notify['avatar']}}" alt="">
											<div class="media-body">
												<a href="{{URL::to('/').'/bai-viet/'.$notify['not_art_id'].'-'.$notify['art_seo_title'].'.html#comments'}}"><strong>{{$notify['signature']}}</strong> @if($notify['not_type'] == 1) đã bình luận về 1 bài viết của bạn @endif @if($notify['not_type'] == 2) đã trích dẫn 1 bình luận của bạn @endif</a>
												<small class="date"><i class="fa fa-thumbs-up"></i>{{$notify['date_created']}}</small>
											</div>
										</li>
									@endforeach
								@else
								<li><div class="media-body text-center">Không có thông báo nào</div></li>
								@endif
							</ul>
							<div class="dropdown-footer text-center">
								<a href="{{URL::to('/thong-bao.html')}}" class="link">Tất cả thông báo</a>
							</div>
						</div>
						<script>
							$(".btn-notify").click(function(){
								var count_notify_new = $('.count-notify').html();
								var n = $('#count_click_notify').val();
									if(n == 0){
									 $('#count_click_notify').val(1);
								    $(".content-notify").show();
										if(count_notify_new != 0){
										    $.ajax({
												url: "{{URL::to('/ajaxupdatenotify')}}",
												type: "post",
												success: function(html){
													$('.count-notify').html('0');
												},
												error: function(){
													$('.count-notify').html('0');
												}
											});
										 }
									}else{
										 $('#count_click_notify').val(0);
									    $(".content-notify").hide();
									}
							    $(document.body).not($(".content-notify")).one('click',function(e) {
							        $(".content-notify").hide();
							        $('#count_click_notify').val(0);
							    });
							        return false;
							});
						</script>
					</div>
					<span>|</span><a href="{{route('logout')}}">Thoát</a>
				</div>
				@endif
			</div>
			<div class="clrb"></div>
		</div>
	</div>
</div>
<div class="search_box">
	<div class="search_left">
		<h2>{{$nameCat or 'Blog Mytour'}}</h2>
	</div>
	<div class="search_right">
		{{Form::open(array('class' => 'inputForm', 'route' => 'search'))}}
				<input type="text" name="key_search" value="" class="ip_search" placeHolder="Tìm kiếm" />
				<input type="submit" name="btn_search" value="" class="btn_search" />
		{{Form::close()}}
	</div>
	<div class="clrb"></div>
</div>
