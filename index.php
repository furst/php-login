<?php

require_once('view/PageView.php');
require_once('view/LoginForm.php');
require_once('controller/Auth.php');
require_once('view/AdminView.php');

$pageView = new \view\PageView();

$loginForm = new \view\LoginForm();

$content = $loginForm->getForm();

session_start();
if(isset($_COOKIE['username'])) {
	$adminView = new \view\AdminView();
	$content = $adminView->getContent();
}

if(isset($_POST['submit'])) {
	$auth = new \controller\Auth();
	$check = $auth->check();

	if ($check == 'true') {
		$adminView = new \view\AdminView();

		if (isset($_POST['stay'])) {
			$content = $adminView->getContent('Vi kommer nu ihåg dig');
		} else {
			$content = $adminView->getContent('Inloggning lyckades');
		}

	} else {
		$content = $loginForm->getForm($check);
	}
}

if (isset($_POST['logout'])) {
	setcookie('username', '', time()-3600);
	$content = $loginForm->getForm('Du har nu loggat ut');
}

echo $pageView->getPage('Labb 1', $content);

