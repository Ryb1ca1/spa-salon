<?php
require 'functions.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $birthday = $_POST['birthday'];

    if (!existsUser($login)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        saveUser($login, $passwordHash, $birthday);
        login($login);
        header('Location: index.php');
        exit;
    } else {
        $error = "User already exists";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>SPA Salon Registration</h1>
        <nav>
            <a href="index.php">Главная</a>
            <a href="login.php">Вход</a>
        </nav>
    </header>
    <main>
        <form action="register.php" method="POST" class="auth-form">
            <label for="login">Логин:</label>
            <input type="text" name="login" id="login" required>
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>
            <label for="birthday">День рождения:</label>
            <input type="date" name="birthday" id="birthday" required>
            <button type="submit">Регистрация</button>
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
