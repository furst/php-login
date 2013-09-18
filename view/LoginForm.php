<?php

namespace view;

class LoginForm {

	private $username = '';

	public function getForm($message = '') {

		if (isset($_POST['username'])) {
			$this->username = $_POST['username'];
		}

		return
		"
		<h2>Ej inloggad</h2>
		<p>$message</p>
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