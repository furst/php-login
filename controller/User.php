<?php

namespace controller;

require_once('view/MainView.php');
require_once('view/AdminView.php');
require_once('model/User.php');
require_once('controller/Redirect.php');

class User {

	/**
	 * @var \view\MainView
	 */
	private $mainView;

	/**
	 * @var \view\LoginForm
	 */
	private $loginForm;

	/**
	 * @var \view\AdminView
	 */
	private $adminView;

	/**
	 * @var \model\User
	 */
	private $user;

	/**
	 * @param \view\MainView  $mainView
	 * @param \view\LoginForm $loginForm
	 * @param \view\AdminView $adminView
	 */
	public function __construct(\view\MainView $mainView, \view\LoginForm $loginForm,
								\view\AdminView $adminView) {
		$this->mainView = $mainView;
		$this->loginForm = $loginForm;
		$this->adminView = $adminView;

		$this->user = new \model\User();
	}

	/**
	 * Make a login attempt
	 */
	public function loginAttempt() {

		$username = $this->loginForm->getUsername();
		$password = $this->loginForm->getPassword();

		if ($this->user->auth($username, $password)) {

			if ($this->loginForm->userWantsToStay()) {
				$this->adminView->setExtraMessage();
				$this->user->setLoginCookie($username, $password);
			} else {
				$this->adminView->setMessage();
			}

			$this->mainView->title('Inloggad')->content($this->adminView->getContent());
		} else {
			$this->loginForm->setErrorMessage();
			$this->mainView->title('Ej inloggad')->content($this->loginForm->getForm());
		}
	}

	/**
	 * logout and redirect to mainpage
	 * @param  boolean $withMessage Show a message or not
	 */
	public function logout($withMessage = true) {

		$this->user->logout();

		if ($withMessage) {
			$this->loginForm->setInfoMessage();
		}

		Redirect::to('index.php');
	}

	public function isLoggedIn() {

		if ($this->user->isSessionHijacked()) {
			return;
		}

		$cookieUsernameHolder = $this->user->loginSessionUsername;
		$cookiePasswordHolder = $this->user->loginSessionPassword;

		$username = $this->getCookieValue($cookieUsernameHolder);
		$password = $this->getCookieValue($cookiePasswordHolder);

		if($this->user->isLoggedIn()) {
			$this->mainView->title('Inloggad')->content($this->adminView->getContent());
			exit();
		} elseif($this->mainView->isCookieSet($cookieUsernameHolder) && $this->mainView->isCookieSet($cookiePasswordHolder)) {
			if($this->user->authCookie($username, $password)) {
				if ($this->user->getCookieDate() < time()) {
					$this->loginForm->setCookieMessage();
					$this->logout(false);
				}
				$this->adminView->setCookieMessage();
				$this->mainView->title('Inloggad')->content($this->adminView->getContent());
				exit();
			} else {
				$this->loginForm->setCookieMessage();
				$this->logout(false);
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