@extends('admin::_layout.template_content')

@section('main')
	<form action="{{ route('usr.reset.post') }}" method="POST">
		<input type="hidden" name="token" value="{{ $token }}"> <input type="email" name="email">
		<input type="password" name="password"> <input type="password" name="password_confirmation">
		<input type="submit" value="Reset Password">
	</form>
@stop