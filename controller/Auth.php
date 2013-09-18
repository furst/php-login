<?php

namespace controller;

class Auth {

	private $username = "Admin";
	private $password = "Password";
	public $pageView;

	public function check() {
		if ($_POST['username'] == $this->username && $_POST['password'] == $this->password) {

			if (isset($_POST['stay'])) {
            /* Set cookie to last 1 year */
            setcookie('username', $_POST['username'], time()+60*60*24*365);

	        } else {
	            /* Cookie expires when browser closes */
	            setcookie('username', $_POST['username'], false);
	        }

			return 'true';
		} else {
			if (empty($_POST['username'])) {
				return 'Användarnamn saknas';
			} elseif (empty($_POST['password'])) {
				return 'Lösenord saknas';
			} else {
				return 'Användarnamnet eller lösenordet är felaktigt';
			}
		}

	}
}