<?php

require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../View/UserListView.php';

class UserController {
    public function listUsers() {
        $model = new UserModel();
        return $model->getAllUsers();
    }

    public function registerUser($name, $password) {
        $model = new UserModel();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $model->registerUser($name, $hashedPassword);
    }
}
