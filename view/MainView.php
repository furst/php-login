<?php

namespace view;

class MainView {

	/**
	 * @param  string $cookieName place in cookie
	 * @return string
	 */
	public function getCookie($cookieName) {
		return $_COOKIE[$cookieName];
	}

	/**
	 * @param  string  $cookieName place in cookie
	 * @return boolean
	 */
	public function isCookieSet($cookieName) {
		if (isset($_COOKIE[$cookieName])) {
			return true;
		}
		return false;
	}

	/**
	 * Echoes the html page
	 * @param  string $content part of html page
	 */
	public function content($content) {

		$month = $this->getMonth();
		$day = $this->getDay();
		$dayOfMonth = date('d');
		$year = date('Y');
		$time = date('G:i:s');

		echo
		"
			<!DOCTYPE html>
			<html>
			<head>
				<title>Labb 3.1</title>
				<meta charset='utf-8'>
				<link rel='stylesheet' href='style.css'>
			</head>
			<body>
				<h1>Laborationskod af222ht</h1>
				<hr>
				$content
				<hr>
				$day, den $dayOfMonth $month år $year. klockan är [$time].
			</body>
			</html>
		";
	}

	/**
	 * @return string
	 */
	private function getMonth() {
		switch (date('m')) {
			case '1':
				return 'Januari';
				break;
			case '2':
				return 'Februari';
				break;
			case '3':
				return 'Mars';
				break;
			case '4':
				return 'April';
				break;
			case '5':
				return 'Maj';
				break;
			case '6':
				return 'Juni';
				break;
			case '7':
				return 'Juli';
				break;
			case '8':
				return 'Augusti';
				break;
			case '9':
				return 'September';
				break;
			case '10':
				return 'Oktober';
				break;
			case '11':
				return 'November';
				break;
			case '12':
				return 'December';
				break;
		}
	}

	/**
	 * @return string
	 */
	private function getDay() {
		switch (date('D')) {
			case 'Mon':
				return 'Måndag';
				break;
			case 'Tue':
				return 'Tisdag';
				break;
			case 'Wed':
				return 'Onsdag';
				break;
			case 'Thu':
				return 'Torsdag';
				break;
			case 'Fri':
				return 'Fredag';
				break;
			case 'Sat':
				return 'Lördag';
				break;
			case 'Sun':
				return 'Söndag';
				break;
		}
	}
}