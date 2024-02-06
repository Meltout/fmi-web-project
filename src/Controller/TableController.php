<?php
require_once __DIR__ . '/../Model/TableModel.php';

class TableController {
    private $tableModel;

    public function __construct() {
        $this->tableModel = new TableModel();
    }

    public function getAllTables() {
        return $this->tableModel->getAllTables();
    }

    public function getTableInfo($tableId) {
        return $this->tableModel->getTableInfo($tableId);
    }

    public function getCellInfo($tableId, $cellX, $cellY) {
        return $this->tableModel->getCellInfo($tableId, $cellX, $cellY);
    }

    public function createTable($name, $width, $height) {
        return $this->tableModel->createTable($name, $width, $height);
    }

    public function updateOrCreateCell($tableID, $ownerID, $value, $cellX, $cellY) {
        return $this->tableModel->updateOrCreateCell($tableID, $ownerID, $value, $cellX, $cellY);
    }
}
