<?php

namespace Controllers;

use Models\TableModel;
use Views\TableView;

class TableController {
    private $model;

    public function __construct(TableModel $model) {
        $this->model = $model;
    }

    public function updateCellValue($row, $col, $value) {
        // Update the value in the model
        $this->model->setValue($row, $col, $value);
    }

    public function renderView() {
        // Render the view using the model
        TableView::render($this->model);
    }
}