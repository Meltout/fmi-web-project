<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../src/Controller/TableController.php';

$controller = new TableController();
$tableCreationMessage = '';
$tables = $controller->getAllTables();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['width']) && isset($_POST['height'])) {
    $name = $_POST['name'];
    $width = $_POST['width'];
    $height = $_POST['height'];

    $tableCreationResult = $controller->createTable($name, $width, $height);

    if ($tableCreationResult['success']) {
        
    } else {
        $tableCreationMessage = $tableCreationResult['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table List</title>
</head>
<body>
    <h1>Tables</h1>
    <form action="" method="post">
        <label for="name">Table name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="width">Width:</label>
        <input type="number" id="width" name="width" required>

        <label for="height">Height:</label>
        <input type="number" id="height" name="height" required>

        <button type="submit">Create new table</button>
    </form>
    
    <p><?= $tableCreationMessage ?></p>
    <ul>
        <?php foreach ($tables as $table) : ?>
            <li>
                <button><a href="tableView.php?tableID=<?= htmlspecialchars($table['tableID']) ?>">Edit table</a></button>
                <?= htmlspecialchars($table['tableName']) ?> - Owner: <?= htmlspecialchars($table['ownerName']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php">Go back to main page.</a>
</body>
</html>
