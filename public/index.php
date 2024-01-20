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
    $pdo = new PDO('sqlite:mydatabase.sqlite');

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
</body>
</html>
