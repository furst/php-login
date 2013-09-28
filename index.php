<?php

require_once('view/MainView.php');
require_once('view/LoginForm.php');
require_once('controller/App.php');
require_once('view/AdminView.php');

session_start();

$app = new \controller\App();

$app->run();

