<?php
require_once 'Database.php';
require_once 'TokenVerificationModel.php';

class UserModel {

  const TWO_WEEKS_IN_SECONDS = 2 * 7 * 24 * 60 * 60;
  private $verificationModel;

  public function __construct() {
    $this->verificationModel = new VerificationModel();
  }

    public function registerUser($name, $password) {
      $pdo = Database::getInstance();
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      try {
          $stmt = $pdo->prepare("INSERT INTO users (name, password) VALUES (:name, :password)");
  
          $stmt->bindParam(':name', $name);
          $stmt->bindParam(':password', $hashedPassword);
  
          if ($stmt->execute()) {
              return ['success' => true, 'message' => "Successfully registered."];
          } else {
              return ['success' => false, 'message' => "Registration failed"];
          }
      } catch (PDOException $e) {
          if ($e->getCode() == '23000') {
              return ['success' => false, 'message' => 'Name already exists'];
          } else {
              return ['success' => false, 'message' => "Registration failed"];
          }
      }
    }

    public function login($username, $password) {
      $pdo = Database::getInstance();
      
      try {
          $stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE name = :name");
          $stmt->bindParam(':name', $username);
          $stmt->execute();
          $user = $stmt->fetch(PDO::FETCH_ASSOC);
          if ($user && password_verify($password, $user['password'])) {
            
              $token = $this->verificationModel->issueToken($user['id']);
  
              if ($token) {
                  return [
                      'success' => true,
                      'message' => 'Login successful',
                      'token' => $token,
                      'user_id' => $user['id'],
                  ];
              } else {
                  return [
                      'success' => false,
                      'message' => 'Failed to issue JWT token',
                      'token' => null,
                  ];
              }
          } else {
              return [
                  'success' => false,
                  'message' => 'Invalid credentials',
                  'token' => null,
              ];
          }
      } catch (PDOException $e) {
          return [
              'success' => false,
              'message' => 'Server error',
              'token' => null,
          ];
      }
  }
  
}
  