<?php

require_once('controller/App.php');

session_start();

$app = new \controller\App();

$app->run();

