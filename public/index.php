<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Hello World</title>
</head>
<body>
    <h1>Hello, World!</h1>
    <p>Users:</p>
    <?php
    // Your SQLite database connection
    $pdo = new PDO('sqlite:../mydatabase.sqlite');

    // Query to fetch users
    $query = $pdo->query('SELECT * FROM users');
    $users = $query->fetchAll(PDO::FETCH_ASSOC);

    // Display users
    echo '<ul>';
    foreach ($users as $user) {
        echo '<li>' . htmlspecialchars($user['name']) . '</li>';
    }
    echo '</ul>';
    ?>
    <?php
    require __DIR__ . '/../vendor/autoload.php';
    // Create an instance of GridModel and GridController
    $rows = 3;
    $cols = 3;
    $model = new \Models\TableModel($rows, $cols);
    $controller = new \Controllers\TableController($model);

    // Set initial values (you can modify this as needed)
    $controller->updateCellValue(0, 0, 'A');
    $controller->updateCellValue(1, 1, 'B');
    $controller->updateCellValue(2, 2, 'C');

    // Handle user input (assuming a simple form submission)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Assuming form fields are named row, col, and value
        $row = $_POST["row"];
        $col = $_POST["col"];
        $value = $_POST["value"];

        // Update the cell value based on user input
        $controller->updateCellValue($row, $col, $value);
    }

    // Render the view
    $controller->renderView();
    ?>

</body>
</html>
