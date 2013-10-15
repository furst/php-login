<?php

namespace view;

class LoginView {

	//positions in input arrays
	private static $usernameHolder = 'username';
	private static $passwordHolder = 'password';
	private static $stayHolder = 'stay';

	/**
	 * @var string
	 */
	private static $message;

	/**
	 * Check if error message exists and set it
	 */
	public function errorMessage() {
		if ($this->hasCookies()) {
			self::$message = "<p>Felaktig information i cookie</p>";
		} else {
			if (empty($_POST['username'])) {
				self::$message = "<p>Användarnamn saknas</p>";
			} elseif (empty($_POST['password'])) {
				self::$message = "<p>Lösenord saknas</p>";
			} else{
				self::$message = "<p>Användarnamn eller lösenord är felaktigt</p>";
			}
		}
	}

	public function logout() {
		self::$message = "<p>Du har nu loggat ut</p>";

		setcookie(self::$usernameHolder, '', time()-3600);
		setcookie(self::$passwordHolder, '', time()-3600);
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
	 * @return boolean
	 */
	private function hasCookies() {
		return isset($_COOKIE[self::$usernameHolder]) && isset($_COOKIE[self::$passwordHolder]);
	}

	/**
	 * @return html page
	 */
	public function getForm() {

		$usernameContent = '';
		if (isset($_POST[self::$usernameHolder])) {
			$usernameContent = $_POST[self::$usernameHolder];
		}

		$message = self::$message;

		$username = self::$usernameHolder;
		$password = self::$passwordHolder;
		$stay = self::$stayHolder;

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
				<label for='$password'>Password</label>
				<input type='password' name='$password' id='$password'>
			</p>
			<p>
				<label for='$stay'>Håll mig inloggad</label>
				<input type='checkbox' name='$stay' id='$stay'>
			</p>
			<p>
				<input type='submit' name='submit' value='Logga in'>
			</p>
		</form>
		";
	}

	/**
	 * @return boolean
	 */
	public function userWantsToBeRemembered() {
		return isset($_POST[self::$stayHolder]);
	}

	/**
	 * Set login message
	 * @param string $username
	 * @param string $password
	 */
	public function setLoginMessage($username, $password) {

		if ($this->userWantsToBeRemembered() || $this->hasCookies()) {
			if ($this->hasCookies()) {
				self::$message  = "<p>Inloggning lyckades via cookies</p>";
			} else {
				self::$message  = "<p>Inloggning lyckades och vi kommer ihåg dig nästa gång</p>";
			}

			setcookie(self::$usernameHolder, $username, time()+60);
			setcookie(self::$passwordHolder, $password, time()+60);
		} else {
			self::$message = "<p>Inloggning lyckades</p>";
		}
	}

	/**
	 * @return boolean
	 */
	public function userWantsToLogout() {
		if (isset($_GET['logout'])) {
			return true;
		}
		return false;
	}

	/**
	 * @return string, a part of a html page
	 */
	public function getAdminContent() {

		return
		"
			<h2>Admin är inloggad</h2>

			" . self::$message . "

			<a href='?logout'>Logga ut</a>
		";
	}
}