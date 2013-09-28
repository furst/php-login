<?php

namespace controller;

class Redirect {

	public static function to($page) {
		header("location:$page");
		exit();
	}
}