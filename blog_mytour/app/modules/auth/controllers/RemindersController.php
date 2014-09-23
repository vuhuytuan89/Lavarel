<?php namespace App\Modules\Auth\Controllers;
use Input, Redirect, View, Password, Lang, App, Hash;

class RemindersController extends \Controller {

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return View::make('auth::password.remind', array('register' => 1, 'title' => 'Remind Password'));
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
		$response = Password::remind(Input::only('email'), function($message){
			$message->subject('Reminder Password');
		});
		switch ($response)
		{
			case Password::INVALID_USER:
				return Redirect::back()->with('error', 'Lỗi, bạn hãy thử lại');

			case Password::REMINDER_SENT:
				return Redirect::back()->with('success', 'Chúng tôi đã gửi một email với các thiết lập lại mật khẩu đến email của bạn.');
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		return View::make('auth::password.reset', array('register' => 1, 'title' => 'Reset Password'))->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('error', Lang::get($response));

			case Password::PASSWORD_RESET:
				return Redirect::back()->with('success', 'Bạn đã đổi mật khẩu thành công');
		}
	}

}
