<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../src/Controller/TableController.php';

$controller = new TableController();

if (isset($_GET['tableID'])) {
    $selectedTableID = $_GET['tableID'];
} else {
    header('Location: tables.php');
    exit();
}

$tableInfo = $controller->getTableInfo($selectedTableID);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the edited cell values from the form submission
    $editedCells = $_POST['cell'];

    // Loop through the edited cells and update the database
    foreach ($editedCells as $row => $columns) {
        foreach ($columns as $col => $value) {
            $controller->updateOrCreateCell($_GET['tableID'], $_SESSION['user_id'], $value, $row, $col);
        }
    }

    // Redirect back to the table view page or another appropriate location
    header('Location: tableView.php?tableID=' . $_GET['tableID']);
    exit();
}
?>

<html>
<head>
    <link rel="stylesheet" href="/assets/style.css">
    <title>Edit Table</title>
</head>
<body>
    <h1>Edit Table</h1>

    <?php foreach ($tableInfo as $table) : ?>
        <h2>Table: <?= htmlspecialchars($table['tableName']) ?></h2>

        <form method="post" action="">
            <input type="hidden" name="tableID" value="<?= $selectedTableID ?>">
            <table class="editTable">
                <?php
                // Loop through the rows and columns to display the table
                for ($row = 0; $row < $table['height']; $row++) {
                    echo '<tr>';
                    for ($col = 0; $col < $table['width']; $col++) {
                        $cellInfo = $controller->getCellInfo($selectedTableID, $row, $col);

                        $cellValue = ($cellInfo !== false && !empty($cellInfo)) ? htmlspecialchars($cellInfo[0]['value']) : "";
                        echo '<td><input type="text" name="cell[' . $row . '][' . $col . ']" value="' . $cellValue .' " ' . (!empty($cellInfo) && $cellInfo[0]['ownerID'] == $_SESSION['user_id'] ? '' : 'disabled') . '></td>';
                    }
                    echo '</tr>';
                }
                ?>
            </table>
            <input type="submit" value="Save Changes">
        </form>
    <?php endforeach; ?>

    <a href="tables.php">Go back to table list page.</a>
</body>
</html>