<?php

namespace view;

class AdminView {

	public function getContent() {
		return
		"
			<h2>Du är inloggad</h2>

			<a href='logout.php'>Logga ut</a>
		";
	}
}