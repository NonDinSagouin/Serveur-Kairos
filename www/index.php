<?php
require __DIR__ . '/base/AutoLoader.php';
use app\Init;
use base\DotEnv;

(new DotEnv(__DIR__ . '/.env'))->load();
Init::startApplication(__DIR__);

// echo getenv('APP_ENV');