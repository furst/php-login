<?php

namespace view;

class LoginForm {

	public function getForm($message = '') {
		return
		"
		<div>
			<p>$message</p>
		</div>
		<form action='?login' method='post'>
			<p>
				<label for='username'>Username</label>
				<input type='text' name='username' id='username'>
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