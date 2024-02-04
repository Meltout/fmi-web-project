<?php
require_once __DIR__ . '/../Model/UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }


    public function registerUser($name, $password) {
        return $this->userModel->registerUser($name, $password);
    }

    public function loginUser($username, $password) {
        $loginResult = $this->userModel->login($username, $password);
        return $loginResult;
    }
}
