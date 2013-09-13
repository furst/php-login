<?php

require_once('view/PageView.php');
require_once('view/AdminView.php');

$pageView = new \view\PageView();

$adminView = new \view\AdminView();

echo $pageView->getPage('Inloggad', $adminView->getContent());