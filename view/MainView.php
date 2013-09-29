<?php

namespace view;

class MainView {

	private $title;

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
				<title>$this->title</title>
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

		return $this;
	}

	public function title($title) {
		$this->title = $title;

		return $this;
	}

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