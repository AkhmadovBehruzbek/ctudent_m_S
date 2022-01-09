<?php
require_once('./config/dbConnection.php');
require_once('./functions.php');



if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['confirm']) && !empty($_POST['confirm'])) {

    $errors = [];
    $sql = "SELECT * FROM admin WHERE login = :login";
    $state = $conn->prepare($sql);
    $state->bindValue(':login', $_POST['login']);
    $result = $state->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $errors = ['err1' => 'Bunday loginga ega foydalanuvchi mavjud'];
        echo $errors['err1'];
    } else {
        $userLogin = filterData($_POST['login']);
        $userPassword = filterData($_POST['password']);
        $userConfirm = filterData($_POST['confirm']);
        if ($userPassword === $userConfirm) {
            $sql = "INSERT INTO admin (`login`, `password`) VALUES (:userLogin, :password)";
            $state = $conn->prepare($sql);
            $state->bindValue(':password', $userPassword);
            $state->bindValue(':userLogin', $userLogin);
            if ($state->execute()) {header('Location: login.php');}
        } else {
            $errors = ['err2' => 'Parolni qayta kiritishda xatolik'];
            echo "<h2>" . $errors['err2'] . "</h2>";
        }

    }
}


function filterData($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<link rel="stylesheet" href="assets/css/register.css">
<div class="login">
    <div class="login-triangle"></div>

    <h2 class="login-header">Register</h2>

    <form class="login-container" method="post">
        <p><input type="text" name="login" placeholder="Login"></p>
        <p><input type="password" name="password" placeholder="Parol"></p>
        <p><input type="password" name="confirm" placeholder="Confirm"></p>
        <p><input type="submit" name="submit" value="Register"></p>
        <p><a href="login.php">login</a></p>
    </form>
</div>