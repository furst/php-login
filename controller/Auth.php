<?php

namespace controller;

class Auth {

	private $username = "adde";
	private $password = "abc123";

	public function check() {
		if ($_POST['username'] == $this->username && $_POST['password'] == $this->password) {
			header('location:admin.php');
		}
	}
}