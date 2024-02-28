<?php

function dd($value) {
    echo "<pre>";
    var_dump($value);
    die(0);
    echo "</pre>";
}

function pd($value) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

function login($user) {
    $_SESSION['user'] = $user;
}

function isLoggedIn() {
    return $_SESSION['user'] ?? false;
}

function base_path($file) {
    return BASE_PATH . $file;
}

function view($path, $options = []) {
    extract($options);
    require(BASE_PATH . "/view/" . $path);
}