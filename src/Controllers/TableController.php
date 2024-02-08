<?php

namespace Controllers;

use Models\TableModel;

class TableController {
    public function updateCellValue($row, $col, $value) {
        // Update the value in the model
        $this->model->setValue($row, $col, $value);
    }

    public function show($id) {
        // Render the view using the model
        $table = (new TableModel(4, 6))->getTable();
        require_once __DIR__ . '/../Views/table.php';
    }
}