<?php
session_start();
require_once '../src/Controller/UserController.php';
 
$userController = new UserController();

$loginStatus = '';
$loginMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginResult = $userController->loginUser($username, $password);

    if ($loginResult['success']) {
      $_SESSION['user_id'] = $loginResult['user_id']; 
      $_SESSION['jwt_token'] = $loginResult['token'];
    
        header('Location: index.php');
        exit();
    } else {
        $loginStatus = 'error';
        $loginMessage = $loginResult['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if ($loginStatus === 'error') : ?>
            <p class="error-message"><?= $loginMessage ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
