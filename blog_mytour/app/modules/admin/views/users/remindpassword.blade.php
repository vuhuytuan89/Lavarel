@extends('admin::_layout.template_content')

@section('main')
	<form action="{{ route('usr.remind.post') }}" method="POST">
		<input type="email" name="email">
		<input type="submit" value="Send Reminder">
	</form>
@stop