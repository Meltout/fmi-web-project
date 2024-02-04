<?php
require_once __DIR__ . '/../Model/TokenVerificationModel.php';

class AuthenticationController {
    private $tokenVerificationModel;

    public function __construct() {
        $this->tokenVerificationModel = new TokenVerificationModel();
    }

    public function verifyToken($token) {
        return $this->tokenVerificationModel->verifyToken($token);
    }
}
