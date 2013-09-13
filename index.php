<?php

require_once('view/PageView.php');
require_once('view/LoginForm.php');

$pageView = new \view\PageView();

$loginForm = new \view\LoginForm();

echo $pageView->getPage('Labb 1', $loginForm->getForm());