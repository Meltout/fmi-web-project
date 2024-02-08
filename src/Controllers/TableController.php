<?php

namespace Controllers;

use Models\TableModel;

class TableController {
    public function show($id) {
        $table = (new TableModel($id));
        require_once __DIR__ . '/../Views/table.php';
    }
}