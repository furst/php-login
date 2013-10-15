<?php

namespace controller;

require_once('view/MainView.php');
require_once('model/User.php');
require_once('controller/Redirect.php');

class User {

	/**
	 * @var \view\MainView
	 */
	private $mainView;

	/**
	 * @var \view\loginView
	 */
	private $loginView;

	/**
	 * @var \model\User
	 */
	private $user;

	/**
	 * @param \view\MainView  $mainView
	 * @param \view\LoginView $loginView
	 */
	public function __construct(\view\MainView $mainView, \view\LoginView $loginView) {
		$this->mainView = $mainView;
		$this->loginView = $loginView;

		$this->user = new \model\User();
	}

	/**
	 * Make a login attempt
	 */
	public function loginAttempt() {

		$username = $this->loginView->getUsername();
		$password = sha1($this->loginView->getPassword());

		if ($this->user->auth($username, $password)) {

			$this->user->write(time()+60);

			$this->loginView->setLoginMessage($username, $password);

			$this->mainView->content($this->loginView->getAdminContent());
		} else {
			$this->mainView->content($this->loginView->getForm());
		}
	}

	/**
	 * logout and redirect to mainpage
	 * @param  boolean $withMessage Show a message or not
	 */
	public function logout($withMessage = true) {

		$this->user->logout();

		$this->loginView->logout();
	}

	/**
	 * Check if user is logged in
	 * @return boolean
	 */
	public function isLoggedIn() {

		$cookieUsernameHolder = $this->user->loginSessionUsername;
		$cookiePasswordHolder = $this->user->loginSessionPassword;

		$username = $this->getCookieValue($cookieUsernameHolder);
		$password = $this->getCookieValue($cookiePasswordHolder);

		if($this->user->isLoggedIn()) {
			return true;
		} else if($this->mainView->isCookieSet($cookieUsernameHolder) && $this->mainView->isCookieSet($cookiePasswordHolder)) {
			return true;
		}
		return false;
	}

	/**
	 * Check if user is logged in and do actions
	 * @return boolean if session is hijacked
	 */
	public function loggedInUser() {

		if ($this->user->isSessionHijacked()) {
			return;
		}

		$cookieUsernameHolder = $this->user->loginSessionUsername;
		$cookiePasswordHolder = $this->user->loginSessionPassword;

		$username = $this->getCookieValue($cookieUsernameHolder);
		$password = $this->getCookieValue($cookiePasswordHolder);

		if($this->user->isLoggedIn()) {
			$this->mainView->content($this->loginView->getAdminContent());
			exit();
		} else if($this->mainView->isCookieSet($cookieUsernameHolder) && $this->mainView->isCookieSet($cookiePasswordHolder)) {
			if($this->user->authCookie($username, $password)) {
				if ($this->user->getCookieDate() < time()) {
					$this->logout(false);
					$this->loginView->errorMessage();
				} else {
					$this->user->write(time()+60);
					$this->user->auth($username, $password);
					$this->loginView->setLoginMessage($username, $password);
					$this->mainView->content($this->loginView->getAdminContent());
					exit();
				}
			} else {
				$this->logout(false);
				$this->loginView->errorMessage();
			}
		}
	}

	/**
	 * @param  string $cookieHolder
	 * @return string cookievalue
	 */
	private function getCookieValue($cookieHolder) {
		if ($this->mainView->isCookieSet($cookieHolder)) {
			return $this->mainView->getCookie($cookieHolder);
		} else {
			return '';
		}
	}
}