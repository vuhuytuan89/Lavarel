<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{{{ $title or 'Admin Page' }}}</title>
	@include('admin::_partial.head')
</head>
<body>
<!-- Start #body -->
<div id="body">
	<!-- Start #main -->
	<div id="main">
		@include('admin::_partial.header')
		@yield('main')
	</div>
	<!-- script tab iframe -->
	<script>
		function tab_iframe(name, page){
			if(name !='homepage'){
				var url = '{{URL::to("/admin/")}}/'+page;
				var id = page.replace('/', '_');
				var check_ifrm = $('#main').find('#'+id).length;
				var check_nav = $('#nav_header').find('#'+page).length;
				if(check_ifrm == 0){
					$('#main').append('<iframe id="'+id+'" src="'+url+'"></iframe>');
					$('#main iframe').filter('iframe').hide();
					$('#main #'+id).show();
				}else{
					var url = $('#main #' + id).attr("src");
					console.log(url);
					$('#' + id).attr("src", $('#' + id).attr("src"));
					$('#main iframe').filter('iframe').hide();
					$('#main #' + id).show();
				}
				if(check_nav == 0){
					$('#nav_header').append('<li class="current" id="'+page+'"><a onclick="tab_iframe(&#39;'+name+'&#39;, &#39;'+ page +'&#39;)" href="javascript:void(0)">'+name+'</a><a href="javascript:void(0)" class="close_tab" onclick="close_tab(&#39;'+page+'&#39;)"></a></li>');
				}
				$('#nav_header li').filter('.current').removeAttr('class');
				$('#nav_header #'+page).attr('class', 'current');
				$('#admin_home_page').hide();
			}else{
				$('#admin_home_page').show();
				$('#nav_header li').filter('li').removeAttr('class');
				$('#nav_header #'+page).attr('class', 'current');
				$('#main iframe').filter('iframe').css('display', 'none');
			}
		}
		function close_tab(id){
			$('#nav_header #'+id).remove();
			$('#main #'+id).remove();
			$('#admin_home_page').show();
			$('#nav_header li').filter('li').removeAttr('class');
			$('#nav_header #homepage').attr('class', 'current');
		}
	</script>
	<!-- Start #sidebar -->
	<div id="sidebar">
		<div class="menu">
			<div class="portlet portlet-closable">
				<div class="portlet-header">
					<h4>Category</h4>
					<span class="portlet-toggle-icon"></span>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a class="icn_manage_pages" href="javascript:void(0)" onclick="tab_iframe('category', 'category')">Quản lý Danh mục</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="menu">
			<div class="portlet portlet-closable portlet-state-closed">
				<div class="portlet-header">
					<h4>Article</h4>
					<span class="portlet-toggle-icon"></span>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a class="icn_manage_pages" href="javascript:void(0)" onclick="tab_iframe('article', 'article')">Quản lý bài viết</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="menu">
			<div class="portlet portlet-closable portlet-state-closed">
				<div class="portlet-header">
					<h4>Comment</h4>
					<span class="portlet-toggle-icon"></span>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a class="icn_manage_pages" href="javascript:void(0)" onclick="tab_iframe('comment', 'comment')">Quản lý Comment</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="menu">
			<div class="portlet portlet-closable portlet-state-closed">
				<div class="portlet-header">
					<h4>Quản lý Admin</h4>
					<span class="portlet-toggle-icon"></span>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a class="icn_manage_pages" href="javascript:void(0)" onclick="tab_iframe('admin', 'index')">Quản lý Admin</a></li>
						<li><a class="icn_add_pages" href="javascript:void(0)" onclick="tab_iframe('Đổi mật khẩu admin', 'changepass')">Đổi mật khẩu</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="menu">
			<div class="portlet portlet-closable portlet-state-closed">
				<div class="portlet-header">
					<h4>Quản lý User</h4>
					<span class="portlet-toggle-icon"></span>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a class="icn_manage_pages" href="javascript:void(0)" onclick="tab_iframe('user', 'user')">Quản lý User</a></li>
					</ul>
				</div>
			</div>
		</div>

	</div>
	<!-- .menu -->
</div>
<!-- #sidebar -->
<div class="clrb"></div>
<footer>
	@include('admin::_partial.footer')
</footer>
</div>

</body>
</html>
