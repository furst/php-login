<?php

namespace controller;

class Redirect {

	/**
	 * Redirect page
	 * @param  string $page
	 */
	public static function to($page) {
		header("location:$page");
		exit();
	}
}