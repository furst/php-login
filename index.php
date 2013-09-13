<?php

require_once('view/PageView.php');
require_once('view/LoginForm.php');
require_once('controller/Auth.php');

$pageView = new \view\PageView();

$loginForm = new \view\LoginForm();

if(isset($_POST['submit'])) {
	$auth = new \controller\Auth($pageView);
	$auth->check();
}

echo $pageView->getPage('Labb 1', $loginForm->getForm());