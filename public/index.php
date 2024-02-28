<?php

const BASE_PATH = __DIR__ . '/../';

require(BASE_PATH . "functions.php");
require(base_path("database.php"));

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = require(base_path("routes.php"));

if (array_key_exists($uri, $routes)) {
    require(base_path($routes[$uri]));
} else {
    view("404.view.php");
}