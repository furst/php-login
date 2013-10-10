<?php

namespace view;

class LoginForm {

	/**
	 * Location in $_SESSION for an error massage
	 * @var string
	 */
	private static $errorMessageHolder = 'view::LoginForm::ErrorMessage';

	/**
	 * Location in $_SESSION for an info message
	 * @var string
	 */
	private static $infoMessageHolder = 'view::LoginForm::InfoMessage';

	/**
	 * Location in $_SESSION for a cookiemessage
	 * @var string
	 */
	private static $infoCookieHolder = 'view::LoginForm::CookieMessage';

	/**
	 * Location in $_POST for username
	 * @var string
	 */
	private static $usernameHolder = 'username';

	/**
	 * Location in $_POST for password
	 * @var string
	 */
	private static $passwordHolder = 'password';

	/**
	 * @var string
	 */
	private static $message;

	public function setErrorMessage() {
		$_SESSION[self::$errorMessageHolder] = true;
	}

	public function setInfoMessage() {
		$_SESSION[self::$infoMessageHolder] = true;
	}

	public function setCookieMessage() {
		$_SESSION[self::$infoCookieHolder] = true;
	}

	/**
	 * Check if error message exists and set it
	 */
	public function checkMessage() {
		if (empty($_POST['username'])) {
			self::$message = "<p>Användarnamn saknas</p>";
		} elseif (empty($_POST['password'])) {
			self::$message = "<p>Lösenord saknas</p>";
		} elseif (isset($_SESSION[self::$errorMessageHolder])) {
			self::$message = "<p>Användarnamn eller lösenord är felaktigt</p>";
			unset($_SESSION[self::$errorMessageHolder]);
		}
	}

	/**
	 * @return boolean
	 */
	public function submitLogin() {
		if (isset($_POST['submit'])) {
			return true;
		}
		return false;
	}

	/**
	 * @return boolean
	 */
	public function userWantsToStay() {
		if (isset($_POST['stay'])) {
			return true;
		}
		return false;
	}

	/**
	 * @return string
	 */
	public function getUsername() {
		return $_POST[self::$usernameHolder];
	}

	/**
	 * @return string
	 */
	public function getPassword() {
		return $_POST[self::$passwordHolder];
	}

	/**
	 * Check if message exists coming from another page
	 * @param  string $session place in session
	 * @param  string $message
	 */
	private function checkDistanceMessage($session, $message) {
		if (isset($_SESSION[$session])) {
			self::$message = "<p>$message</p>";
			unset($_SESSION[$session]);
		}
	}

	/**
	 * @return html page
	 */
	public function getForm() {

		$usernameContent = '';
		if (isset($_POST[self::$usernameHolder])) {
			$usernameContent = $_POST[self::$usernameHolder];
		}

		$this->checkDistanceMessage(self::$infoMessageHolder, 'Du har nu loggat ut');
		$this->checkDistanceMessage(self::$infoCookieHolder, 'Felaktig information i cookie');

		$message = self::$message;

		$username = self::$usernameHolder;
		$password = self::$passwordHolder;

		return
		"
		<h2>Ej inloggad</h2>
		$message
		<form action='?login' method='post'>
			<p>
				<label for='$username'>Username</label>
				<input type='text' name='$username' id='$username' value='$usernameContent'>
			</p>
			<p>
				<label for='password'>Password</label>
				<input type='$password' name='$password' id='password'>
			</p>
			<p>
				<label for='stay'>Håll mig inloggad</label>
				<input type='checkbox' name='stay' id='stay'>
			</p>
			<p>
				<input type='submit' name='submit' value='Logga in'>
			</p>
		</form>
		";
	}
}