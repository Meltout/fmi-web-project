<?php

 namespace Views;

use Models\TableModel;

class TableView {
    public static function render(TableModel $model) {
        // Render the HTML table based on the table data
        $table = $model->getTable();

        echo '<table border="1">';
        foreach ($table as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo '<td>' . htmlspecialchars($cell ?? '') . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }
}