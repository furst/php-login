<?php

namespace view;

class AdminView {

	public function getContent($message = '') {

		return
		"
			<h2>Admin är inloggad</h2>

			<p>$message</p>

			<form method='post' action='?logout'>
				<input type='submit' name='logout' value='Logga ut'>
			</form>
		";
	}
}