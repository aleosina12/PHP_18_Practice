<?php

$errors = [];



if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = strip_tags($_POST['login']);
    $password = strip_tags($_POST['password']);

    require_once("checkUser.php");

    if (empty($login) || empty($password)) {
        $errors[] = 'Не заполнен логин или пароль!';
    } else if (!checkUserExists($login)) {
        $errors[] = 'Пользователь не найден!';
    }else if (!checkUserPassword($login, $password)) {
        $errors[] = 'Неверный логин или пароль!';
    }

    if (empty($errors)) {
        session_start();
        $_SESSION['auth'] = true;
        $_SESSION['username'] = $login;
        header('location: loginpage.php');
    }
}

?>


<html>

<head>
    <title>Authorization</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>



<body>
    <div class="container">
        <div class="formblock">
            <h2>Вход</h2>
            <?php foreach ($errors as $error) {
                echo "<div class=\"alert\">$error</div>";
            } ?>

            <?php if (isset($_SESSION['auth']) && empty($_GET['exit'])) : ?>
                <h1>Добро пожаловать, <?php echo $_SESSION['username'] ?> </h1>
                <a href="?exit=1"> Выйти из системы </a>
            <?php else : ?>
                <form method="POST" action="loginform.php">
                    <input type="text" name="login" placeholder="ваш логин">
                    <input type="password" name="password" placeholder="ваш пароль">
                    <input type="submit" value="Войти">
                </form>
                <div><a href="reg.php">Регистрация</a></div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>