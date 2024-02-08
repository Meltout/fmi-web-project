<?php

namespace Models;

use Ratchet\ConnectionInterface;

class TableModel {
    private array $contents; // contains formula for corresponding cell: e.g "3", "$A1+$B2", "some_string" and etc.
    private array $locked_by; // contains id of user who has locked the corresponding cell
    private array $subscribers;
    private int $rows;
    private int $cols;
    
    public function __construct(private int $id) {
        // TODO: load table with table_id from database instead of using constant table
        $this->rows = 5;
        $this->cols = 6;
        $this->contents = array_fill(0, $this->rows * $this->cols, '= 4');
        $this->locked_by = array_fill(0, $this->rows * $this->cols, -1);
    }

    public function save_to_db() {
        // TODO
    }

    public function get_id() {
        return $this->id;
    }

    public function get_value($i, $j) {
        // everything after the equals
        return substr($this->get_formula($i, $j), 2);
    }

    public function get_formula($i, $j) {
        return $this->contents[$i * $this->cols + $j];
    }

    public function get_rows() {
        return $this->rows;
    }

    public function get_cols() {
        return $this->cols;
    }

    public function set_formula($i, $j, $formula) {
        // TODO - check if user has permission to modify the cell (its not locked or its locked by him)
        $this->contents[$i * $this->cols + $j] = $formula;
    }
}
