<div id="megadropdown">

	<ul id="nav_header">
		<li class="current" id="homepage">
			<a href="javascript:void(0)"  onclick="tab_iframe('homepage', 'homepage')">Home</a>
		</li>

		@if(Auth::check())
		    <li id="nav_logout">
				<a href="{{route('admin.logout')}}">Logout</a>
			</li>
		@endif

	</ul>
</div> <!-- #megadropdown -->