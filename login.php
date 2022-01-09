<?php
session_start();
require_once('./config/dbConnection.php');
require_once('./functions.php');

if (isset($_POST['login']) && isset($_POST['password'])) {
    $sql = "SELECT * FROM admin WHERE login = :login AND password = :password";
    $state = $conn->prepare($sql);
    $state->bindValue(':login', $_POST['login']);
    $state->bindValue(':password', $_POST['password']);
    $state->execute();
    $result = $state->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION['login'] = $_POST['login'];
        header('Location: index.php');
    } else {
        echo "<script>alert('Login Yoki Parol Xato'); </script>";
        echo "<noscript>Login Yoki Parol Xato</noscript>";
    }
}
?>
<link rel="stylesheet" href="assets/css/register.css">
<div class="login">
    <div class="login-triangle"></div>

    <h2 class="login-header">Log in</h2>

    <form class="login-container" method="post">
        <p><input type="text" name="login" placeholder="Login"></p>
        <p><input type="password" name="password" placeholder="Parol"></p>
        <p><input type="submit" name="submit" value="Log in"></p>
        <p><a href="register.php">Register</a></p>
    </form>
</div>







