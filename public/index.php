<?php

use App\Controllers\HelloController;

require_once __DIR__ . '/../vendor/autoload.php';

$helloController = new HelloController();
$helloController->dizerOi();
