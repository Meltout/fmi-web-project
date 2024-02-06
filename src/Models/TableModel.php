<?php

namespace Models;

use Ratchet\ConnectionInterface;

class TableModel {
    private $table;

    public function __construct($rows, $cols) {
        // Initialize a 2D table with empty values
        $this->table = array_fill(0, $rows, array_fill(0, $cols, null));
    }

    public function setValue($row, $col, $value) {
        // Set a value in the specified cell
        $this->table[$row][$col] = $value;
    }

    public function getValue($row, $col) {
        // Get the value from the specified cell
        return $this->table[$row][$col];
    }

    public function isEmpty($row, $col) {
        // Check if the specified cell is empty
        return empty($this->table[$row][$col]);
    }

    public function getTable() {
        // Get the entire 2D table
        return $this->table;
    }
}
