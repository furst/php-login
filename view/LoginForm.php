<?php

namespace view;

class LoginForm {

	private $username;
	private static $errorMessageHolder = 'view::LoginForm::ErrorMessage';
	private static $infoMessageHolder = 'view::LoginForm::InfoMessage';
	private static $usernameHolder = 'view::LoginForm::Username';
	private static $message;

	public function setErrorMessage() {
		$_SESSION[self::$errorMessageHolder] = true;
	}

	public function setInfoMessage() {
		$_SESSION[self::$infoMessageHolder] = true;
	}

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

	public function getForm() {

		if (isset($_POST[self::$usernameHolder])) {
			$this->username = $_POST[self::$usernameHolder];
		}

		if (isset($_SESSION[self::$infoMessageHolder])) {
			self::$message = "<p>Du har nu loggat ut(fungerar ej med surftown?)</p>";
			unset($_SESSION[self::$infoMessageHolder]);
		}

		$message = self::$message;

		return
		"
		<h2>Ej inloggad</h2>
		$message
		<form action='?login' method='post'>
			<p>
				<label for='username'>Username</label>
				<input type='text' name='username' id='username' value='$this->username'>
			</p>
			<p>
				<label for='password'>Password</label>
				<input type='password' name='password' id='password'>
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