<?php

namespace model;

class User {

	/**
	 * username from database
	 * @var string
	 */
	private static $dbUsername = 'Admin';

	/**
	 * password from database
	 * @var string
	 */
	private static $dbPassword = 'Password';

	/**
	 * file to read from
	 * @var string
	 */
	private static $file = 'users.txt';

	/**
	 * Location in $_SESSION and $_COOKIE for the username
	 * @var string
	 */
	public $loginSessionUsername = 'username';

	/**
	 * Location in $_SESSION ans $_COOKIE for the password
	 * @var string
	 */
	public $loginSessionPassword = 'password';

	/**
	 * Location in $_SESSION for login
	 * @var string
	 */
	private static $sessionLoginHolder = 'isLoggedIn';

	/**
	 * @param  string $username
	 * @param  string $password
	 * @return boolean
	 */
	public function auth($username, $password) {
		if ($username == self::$dbUsername && $password == sha1(self::$dbPassword)) {
			$_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
			$_SESSION[self::$sessionLoginHolder] = true;
			return true;
		}
		return false;
	}

	/**
	 * Unset cookie and session
	 */
	public function logout() {
		unset($_SESSION[self::$sessionLoginHolder]);
	}

	/**
	 * @param string $username
	 * @param string $password
	 */
	// public function setLoginCookie($username, $password) {
	// 	setcookie($this->loginSessionUsername, $username, time()+60);
	// 	setcookie($this->loginSessionPassword, sha1($password), time()+60);
	// 	$this->write(time()+60);
	// }

	/**
	 * @return boolean
	 */
	public function isSessionHijacked() {
		if (isset($_SESSION['HTTP_USER_AGENT']) || isset($_SESSION['REMOTE_ADDR'])) {
			if ($_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT'] || $_SESSION['REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR']) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @return boolean
	 */
	public function isLoggedIn() {
		if (isset($_SESSION[self::$sessionLoginHolder])) {
			return true;
		}
	}

	/**
	 * Check if cookie is valid
	 * @param  string $username
	 * @param  string $password
	 * @return boolean
	 */
	public function authCookie($username, $password) {
		if($username == self::$dbUsername && $password == sha1(self::$dbPassword)) {
			$_SESSION['isLoggedIn'] = true;
			return true;
		}
	}

	/**
	 * write to file
	 * @param  string $content
	 */
	public function write($content) {
		$fh = fopen(self::$file, 'w') or die("can't open file");
		$data = $content;
		fwrite($fh, $data);
		fclose($fh);
	}

	/**
	 * Get value from file
	 * @return string
	 */
	public function getCookieDate() {
		return file_get_contents(self::$file);
	}
}