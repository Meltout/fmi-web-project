<?php

namespace Controllers;

class HomeController {
    public function show() {
        require_once __DIR__ . '/../Views/home.php';
    }
}