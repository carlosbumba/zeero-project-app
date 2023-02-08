<?php

use App\Controllers\AppController;
use Zeero\Core\Router\Route;

$app = Route::getInstance();

$app->get('/', [AppController::class, 'Index']);