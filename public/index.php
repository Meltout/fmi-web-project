<?php
session_start();

$loggedIn = isset($_SESSION['user_id']);

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['user_id']); 
    unset($_SESSION['jwt_token']);
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="assets/index.css">
</head>
<body>
    <header>
        <h1>Welcome to the Home Page</h1>
    </header>
    <main>
        <?php if ($loggedIn) : ?>
            <p>You are logged in. Welcome!</p>
            <nav>
                <a href="?action=logout">Logout</a>
            </nav>
        <?php else : ?>
            <nav>
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
            </nav>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; <?= date("Y"); ?> Website about tables and formulas!</p>
    </footer>
</body>
</html>
