<?php
session_start();

$curFolder = __DIR__;
$imagesFolder = $curFolder . '/uploads/';
$imageName = "";
$imagePath = "";



if (empty($_GET['id'])) {
    header('location: index.php');
} else {
    $imageName =  $_GET['id'];
    $imagePath = $imagesFolder  . $imageName;
}
$commentsFileName = pathinfo($imageName, PATHINFO_FILENAME) . '.txt';
$commentsFilePath = $imagesFolder . $commentsFileName;
$comments = [];

if (file_exists($commentsFilePath)) {
    $comments = file($commentsFilePath, FILE_IGNORE_NEW_LINES);
}

if (isset($_POST['comm'])) {
    $date = date("Y-m-d H:i:s");
    $commentLine = "\r\n{$_SESSION['username']} говорит: {$_POST['comm']} [$date]";
    file_put_contents($commentsFilePath, $commentLine, FILE_APPEND);
    header("location: view.php?id=$imageName");
}

if(isset($_GET['action']) && $_GET['action']=="delete") {
    unlink($imagePath);
    if (file_exists($commentsFilePath)) {
        unlink($commentsFilePath);
    }
    $previewImagePath = $imagesFolder . '/preview/' . $imageName;
    unlink($previewImagePath);
    header('location: index.php');
}

?>

<html>

<head>
    <title>View image</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="viewImage">
        <p>
            <a href="index.php"> &lt;&lt;&lt;Вернуться в галерею</a>
        </p>

        <img class="viewImageImg" src="<?php echo '\uploads\\' . $imageName ?>">
        <p>
            <a href="/view.php?id=<?php echo $imageName; ?>&action=delete">Удалить картинку</a>
        </p>
        <h3>Комментарии к фото:</h3>
        <div class="comments">
            <?php
            if (count($comments) == 0) {
                echo "Нет комментариев";
            } else {
                foreach ($comments as $comment) {
                    echo "<div class=\"comment\">$comment</div>";
                }
            } ?>
            <?php if (isset($_SESSION['auth'])) : ?>
                <form class="newComment" method="POST" action="/view.php?id=<?php echo $imageName ?>">
                    <input type="text" name="comm" autocomplete="off" placeholder="Я думаю...">
                    <input type="submit" value="Отправить">
                </form>
            <?php else : ?>
                <p>Только <a href="loginform.php">авторизированные</a> пользователи могут оставлять комментарии.</p>
            <?php endif; ?>
        </div>
    </div>


</body>

</html>