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
			</head>
			<body>
				$body
			</body>
			</html>
		";
	}
}