<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{{{ $title or 'Home page' }}}</title>
	<link href="{{URL::to('/assets')}}/images/favicon.ico" rel="icon" type="image/x-icon">
	<link href="{{URL::to('/assets')}}/images/favicon.ico" rel="shortcut icon">
	<meta name="title" content="{{{ $title or 'Home page' }}}">
	<meta name="description" content="{{{ $metadesc or 'Blog Mytour page' }}}">
	<meta name="keywords" content="{{{ $metakey or 'Blog, Mytour' }}}">
	@include('content::_partial.head')
</head>
<body>
<div class="container">
	<div class="wrapper <?php if(isset($slide)) echo 'bgr_home';else{ echo (!isset($register) && !isset($login))?'bgr_search':'bgr_login';} ?>">
		<div class="main">
			<?php if(!isset($register) && !isset($login)){ ?>
				@include('content::_partial.header')
				<div class="layout_2col">
					@yield('header_blogger')
					<div class="col_left">
						@if(isset($breadcrumb) && !empty($breadcrumb))
							<div class="breadcrumb">
								<ul>
									<li><a href="{{URL::to('/')}}">Trang chủ</a></li>
									<?php $i = 1; ?>
										@foreach($breadcrumb as $brd)
											@if($i < count($breadcrumb))
												<li class="arrow_brd"><a href="{{URL::to('/').'/danh-muc/'.$brd['id'].'-'.$brd['seo_name'].'.html'}}">{{$brd['name']}}</a></li>
											@else
												<li class="last_breadcrumb arrow_brd">{{$brd['name']}}</li>
											@endif
											<?php $i++; ?>
										@endforeach
								</ul>
							</div>
						@endif
						@yield('main')
					</div>
					@if(!isset($hidden_colright))
					<div class="col_right">
						@include('content::_partial.col_right')
					</div>
					@endif
				</div>
			<?php }else{ ?>
				@yield('main')
			<?php } ?>
		</div>
	</div>
	<div class="clrb"></div>
	<?php if(!isset($register) && !isset($login)){ ?>
	<footer>
		@include('content::_partial.footer')
	</footer>
	<?php } ?>
</div>

</body>
</html>
