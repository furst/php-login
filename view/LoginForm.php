<?php

namespace view;

class LoginForm {

	public function getForm() {
		return
		"
		<form action='?' method='post'>
			<p>
				<label for='username'>Username</label>
				<input type='text' name='username' id='username'>
			</p>
			<p>
				<label for='password'>Password</label>
				<input type='password' name='username' id='username'>
			</p>
			<p>
				<input type='submit' value='Logga in'>
			</p>
		</form>
		";
	}
}