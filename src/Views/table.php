<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">

<?php
echo '<table border="1">';
foreach ($table as $row) {
    echo '<tr>';
    foreach ($row as $cell) {
        echo '<td>' . htmlspecialchars($cell ?? '') . '</td>';
    }
    echo '</tr>';
}
echo '</table>';
?>