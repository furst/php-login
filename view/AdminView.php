<?php

namespace view;

class AdminView {

	/**
	 * Location in $_SESSION for a standard message
	 * @var string
	 */
	private static $messageHolder = 'view::AdminView::Message';

	/**
	 * Location in $_SESSION for a extra message
	 * @var string
	 */
	private static $extraMessageHolder = 'view::AdminView::ExtraMessage';

	/**
	 * Location in $_SESSION for a cookiemessage
	 * @var string
	 */
	private static $cookieMessageHolder = 'view::AdminView::cookieMessage';

	/**
	 * @var string
	 */
	private $message;

	public function setMessage() {
		$_SESSION[self::$messageHolder] = true;
	}

	public function setExtraMessage() {
		$_SESSION[self::$extraMessageHolder] = true;
	}

	public function setCookieMessage() {
		$_SESSION[self::$cookieMessageHolder] = true;
	}

	/**
	 * Sets a message and removes it in the session after
	 * @param  string $sessionName
	 * @param  string $message
	 */
	private function messageHandeler($sessionName, $message) {
		if (isset($_SESSION[$sessionName])) {
			$this->message = "<p>$message</p>";
			unset($_SESSION[$sessionName]);
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
	public function getContent() {

		$this->messageHandeler(self::$messageHolder, 'Inloggning lyckades');
		$this->messageHandeler(self::$extraMessageHolder, 'Inloggning lyckades och vi kommer ihåg dig nästa gång');
		$this->messageHandeler(self::$cookieMessageHolder, 'Inloggning lyckades via cookies');

		return
		"
			<h2>Admin är inloggad</h2>

			$this->message

			<a href='?logout'>Logga ut</a>
		";
	}
}