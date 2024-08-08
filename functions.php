<?php
session_start();

function getUsersList() {
    $users = file_get_contents('users.json');
    return json_decode($users, true);
}

function saveUsersList($users) {
    file_put_contents('users.json', json_encode($users));
}

function existsUser($login) {
    $users = getUsersList();
    return isset($users[$login]);
}

function checkPassword($login, $password) {
    if (!existsUser($login)) {
        return false;
    }
    $users = getUsersList();
    return password_verify($password, $users[$login]['password']);
}

function getCurrentUser() {
    return $_SESSION['user'] ?? null;
}

function saveUser($login, $passwordHash, $birthday) {
    $users = getUsersList();
    $users[$login] = ['password' => $passwordHash, 'birthday' => $birthday];
    saveUsersList($users);
}

function login($login) {
    $_SESSION['user'] = $login;
    setcookie('login_time', time(), time() + 86400); // 86400 = 1 день
}

function logout() {
    session_destroy();
    setcookie('login_time', '', time() - 3600);
}

function getBirthday($login) {
    $users = getUsersList();
    return $users[$login]['birthday'] ?? null;
}
?>
