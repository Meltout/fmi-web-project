<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../src/Controller/UserController.php';

$controller = new UserController();

$registrationMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['password'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $registrationResult = $controller->registerUser($name, $password);

    if ($registrationResult['success']) {
        header('Location: login.php');
        exit();
    } else {
        $registrationMessage = $registrationResult['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="assets/register.css">
</head>
<body>
    <main class="container">
        <h1>Register</h1>

        <?php if (!empty($registrationMessage)) : ?>
            <p class="error-message"><?= $registrationMessage ?></p>
        <?php endif; ?>

        <form action="register.php" method="post">
            <section class="form-group">
                <label for="name">Username:</label>
                <input type="text" id="name" name="name" required>
            </section>
            <section class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </section>
            <button type="submit">Register</button>
        </form>

        <nav>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </nav>
    </main>
</body>
</html>