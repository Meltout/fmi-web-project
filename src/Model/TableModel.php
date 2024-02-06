<?php
require_once 'Database.php';
require_once 'TokenVerificationModel.php';

class TableModel {
  private $verificationModel;

  public function __construct() {
    $this->verificationModel = new VerificationModel();
  }
    public function getAllTables() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT tl.id AS tableID, tl.name AS tableName, tl.ownerID, u.name AS ownerName FROM table_list tl JOIN users u ON tl.ownerID = u.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTableInfo($tableId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT tl.name AS tableName, tl.width AS width, tl.height AS height, u.name AS ownerName FROM table_list tl JOIN users u ON tl.ownerID = u.id WHERE tl.id = :tableID");
        $stmt->bindParam(':tableID', $tableId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCellInfo($tableId, $cellX, $cellY) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT value, ownerID FROM table_cells WHERE tableID = :tableId AND cellX = :CellX AND cellY = :CellY");
        $stmt->bindParam(':tableId', $tableId);
        $stmt->bindParam(':CellX', $cellX);
        $stmt->bindParam(':CellY', $cellY);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrCreateCell($tableID, $ownerID, $value, $cellX, $cellY)
    {
        // Check if the cell already exists for the given tableID, ownerID, cellX, and cellY
        $existingCell = $this->getCellInfo($tableID, $cellX, $cellY);

        if ($existingCell !== false) {
            // Cell exists, update the value
            $this->updateCellValue($tableID, $cellX, $cellY, $value);
        } else {
            // Cell doesn't exist, add a new row
            $this->addNewCell($tableID, $ownerID, $value, $cellX, $cellY);
        }
    }

    private function updateCellValue($tableID, $cellX, $cellY, $value)
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE table_cells SET value = :value WHERE tableID = :tableID AND cellX = :cellX AND cellY = :cellY");
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':tableID', $tableID);
        $stmt->bindParam(':cellX', $cellX);
        $stmt->bindParam(':cellY', $cellY);
        $stmt->execute();
    }

    private function addNewCell($tableID, $ownerID, $value, $cellX, $cellY)
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO table_cells (tableID, ownerID, value, cellX, cellY) VALUES (:tableID, :ownerID, :value, :cellX, :cellY)");
        $stmt->bindParam(':tableID', $tableID);
        $stmt->bindParam(':ownerID', $ownerID);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':cellX', $cellX);
        $stmt->bindParam(':cellY', $cellY);
        $stmt->execute();
    }

    public function createTable($name, $width, $height) {
        $pdo = Database::getInstance();
        try {
          $stmt = $pdo->prepare("INSERT INTO table_list (name, ownerID, width, height) VALUES (:name, :ownerID, :width, :height)");

          $stmt->bindParam(':name', $name);
          $stmt->bindParam(':ownerID', $_SESSION['user_id']);
          $stmt->bindParam(':width', $width);
          $stmt->bindParam(':height', $height);
          
          if ($stmt->execute()) {
            header('Location: tables.php');
            return ['success' => true, 'message' => "Successfully created table."];
          } else {
            return ['success' => false, 'message' => "Table creation failed"];
          }
        } catch (PDOException $e) {
          if ($e->getCode() == '23000') {
              return ['success' => false, 'message' => 'Width and height must be less than 8.'];
          } else {
              return ['success' => false, 'message' => "Table creation failed"];
          }
        }
    }
}
