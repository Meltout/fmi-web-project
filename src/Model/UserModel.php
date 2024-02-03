<?php
require_once 'Database.php';

class UserModel {
    public function getAllUsers() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT id, name FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerUser($name, $password) {
      $pdo = Database::getInstance();
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  
      try {
          $stmt = $pdo->prepare("INSERT INTO users (name, password) VALUES (:name, :password)");
  
          $stmt->bindParam(':name', $name);
          $stmt->bindParam(':password', $hashedPassword);
  
          if ($stmt->execute()) {
              return "Successfully registered.";
          } else {
              return "Registration failed";
          }
      } catch (PDOException $e) {
          if ($e->getCode() == '23000') {
              return 'Name already exists';
          } else {
              return "Registration failed";
          }
      }
  }
  
}
