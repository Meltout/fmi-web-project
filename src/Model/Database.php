<?php

class Database {
    private static $instance = null;

    private function __construct() {
    }

    public static function getInstance() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO('sqlite:mydatabase.sqlite', null, null, array(
                    PDO::ATTR_PERSISTENT => true, // This makes the connection persistent.
                ));
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$instance;
    }

    private function __clone() {}
    public function __wakeup() {
      throw new Exception("Cannot unserialize a singleton.");
  }
  
}
