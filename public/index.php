<?php
require_once __DIR__ . '/../src/Controller/UserController.php';

$controller = new UserController();

$registrationMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['password'])) {
    $registrationMessage = $controller->registerUser($_POST['name'], $_POST['password']);
}

$users = $controller->listUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
</head>
<body>
    <h1>User List</h1>
    <ul>
        <?php foreach ($users as $user) : ?>
            <li>ID: <?= htmlspecialchars($user['id']) ?> - Name: <?= htmlspecialchars($user['name']) ?></li>
        <?php endforeach; ?>
    </ul>
    
    <p><?= $registrationMessage ?></p>
    
    <h2>Register a New User</h2>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
