<?php
require 'functions.php';

if (getCurrentUser()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (checkPassword($login, $password)) {
        login($login);
        header('Location: index.php');
        exit;
    } else {
        $error = "Invalid login or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>SPA Salon Login</h1>
        <nav>
            <a href="index.php">Главная</a>
            <a href="register.php">Регистрация</a>
        </nav>
    </header>
    <main>
        <form action="login.php" method="POST" class="auth-form">
            <label for="login">Логин:</label>
            <input type="text" name="login" id="login" required>
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Вход</button>
        </form>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 SPA Salon. All rights reserved.</p>
    </footer>
</body>
</html>
