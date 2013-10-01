<?php

namespace model;

class User {

	public $dbUsername = 'Admin';
	public $dbPassword = 'Password';
	private static $file = 'users.txt';

	public function write($content) {
		$fh = fopen(self::$file, 'w') or die("can't open file");
		$data = $content;
		fwrite($fh, $data);
		fclose($fh);
	}

	public function getCookieDate() {
		return file_get_contents(self::$file);
	}

}