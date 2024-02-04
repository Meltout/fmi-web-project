<?php
require_once 'Database.php';
require_once __DIR__ . '/../dependencies/firebase/jwt/src/JWT.php';
require_once __DIR__ . '/../../config.php';

use Firebase\JWT\JWT;

class VerificationModel {
    private $secretKey;
    private $tokenSpan;

    public function __construct() {
        $this->secretKey = SECRET_KEY;
        $this->tokenSpan = JWT_EXPIRATION_TIME;
    }

    public function verifyToken($token) {
      try {
          $decoded = JWT::decode($token, $this->secretKey, ['HS256']);
          
          if ($decoded->exp >= time()) {
              return true; 
          } else {
              return false; 
          }
      } catch (Exception $e) {
          return false; 
      }
  }

    public function issueToken($userId) {
      try {
          $payload = [
              'user_id' => $userId,
              'exp' => time() + $this->tokenSpan,
          ];

          $token = JWT::encode($payload, $this->secretKey, 'HS256');

          return $token;
      } catch (Exception $e) {
          return null;
      }
  }
}
