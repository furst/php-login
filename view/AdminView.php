<?php

namespace view;

class AdminView {

	private static $messageHolder = 'view::AdminView::Message';
	private static $extraMessageHolder = 'view::AdminView::ExtraMessage';
	private static $cookieMessageHolder = 'view::AdminView::cookieMessage';
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

	private function messageHandeler($sessionName, $message) {
		if (isset($_SESSION[$sessionName])) {
			$this->message = "<p>$message</p>";
			unset($_SESSION[$sessionName]);
		}
	}

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