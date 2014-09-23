{{ HTML::style("backend/assets/css/jquery-ui.min.css") }}
{{ HTML::style('backend/assets/css/reset.css') }}
{{ HTML::style('backend/assets/css/typography.css') }}
{{ HTML::style('backend/assets/css/jquery.datetimepicker.css') }}
{{ HTML::style('backend/assets/css/styles.css') }}
{{ HTML::script('assets/js/jquery-1.11.0.min.js') }}
{{ HTML::script('backend/assets/js/jquery.datetimepicker.js') }}
{{ HTML::script('backend/assets/js/carbon.js') }}
{{ HTML::script('backend/assets/js/nav.js') }}
{{ HTML::script('backend/assets/js/carbon.portlet.js') }}
{{ HTML::script('backend/assets/js/function.js') }}
	<script type="text/javascript" charset="utf-8">
		$(function ()
		{
			megadrop.init ();
			carbon.portlet.init ();
		});
	</script>
