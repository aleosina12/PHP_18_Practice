<?php
session_start();
if (empty($_SESSION['auth']) || empty($_SESSION['username'])) {
    header('location: loginform.php');
} else if ($_SESSION['auth'] != true) {
    header('location: loginform.php');
}
?>

<html>

<head>
    <title>Страница входа</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>



<body>
<div class="container">
        <div class="formblock">
            <h2>Вход</h2>
            <?php if (isset($_SESSION['auth']) && isset($_SESSION['username'])) : ?>
                <h1>Добро пожаловать, <?php echo $_SESSION['username'] ?> </h1>
                <a href="index.php"> Перейти в галерею </a>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>