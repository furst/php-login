<?php

namespace view;

class PageView {

	/**
	 * @param  string $title
	 * @param  string $body
	 * @return string HTML
	 */
	public function getPage($title, $body) {
		return
		"
			<!DOCTYPE HTML SYSTEM>
			<html>
			<head>
				<title>$title</title>
				<meta charset='utf-8'>
			</head>
			<body>
				<h1>Login</h1>
				$body
			</body>
			</html>
		";
	}
}