<?php
require 'config.php';

$errors = [];
$messages = [];

$imageFileName = $_GET['name'];
$commentFilePath = COMMENT_DIR . '/' . $imageFileName . '.txt';


if(!empty($_POST['comment'])) {

    $comment = trim($_POST['comment']);

    // Валидация коммента
    if($comment === '') {
        $errors[] = 'Вы не ввели текст';
    }

    if(empty($errors)) {
     
       file_put_contents($commentFilePath,  $comment . "\n", FILE_APPEND);
        $messages[] = 'Комментарий добавлен';
    }
}


$comments = file_exists($commentFilePath)
    ? file($commentFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
    : [];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Галерея изображений | Файл <?php echo $imageFileName; ?></title>
</head>
<body>


<div class="container pt-4">

    <h1 class="mb-4"><a href="<?php echo URL; ?>">Галерея изображений</a></h1>

    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endforeach; ?>

    <?php foreach ($messages as $message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endforeach; ?>

    <h2 class="mb-4">Файл <?php echo $imageFileName; ?></h2>

    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2">

            <img src="<?php echo URL . '/' . UPLOAD_DIR . '/' . $imageFileName ?>" class="img-thumbnail mb-4"
                 alt="<?php echo $imageFileName ?>">

            <h3>Комментарии</h3>
            <?php if(!empty($comments)): ?>
                <?php foreach ($comments as $key => $comment): ?>
                    <p class="<?php echo (($key % 2) > 0) ? 'bg-light' : ''; ?>"><?php echo $comment; ?></p>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Пока ни одного коммантария, будьте первым!</p>
            <?php endif; ?>

            <!-- Форма добавления комментария -->
            <form method="post">
                <div class="form-group">
                    <label for="comment">Ваш комментарий</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
    </div>

</div


</body>
</html>
