<?php
define('UPLOAD_MAX_SIZE', 5000000);

const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif'];
var_dump(ALLOWED_TYPES);

define('UPLOAD_DIR', 'uploads');

session_start();
if (empty($_SESSION['auth']) || $_SESSION['auth'] != true) {
    header('location: loginform.php');
}



$errors = [];
$success = 0;
if (isset($_FILES)) {
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
        $fileName = $_FILES['files']['name'][$i];

        if ($_FILES['files']['size'][$i] > UPLOAD_MAX_SIZE) {
            $errors[] = "Недопустимый размер файла " . $fileName;
            continue;
        }
        if (!in_array($_FILES['files']['type'][$i], ALLOWED_TYPES)) {
            echo "file type " . $_FILES['files']['type'][$i];
            echo "<br><br>";
            
            $errors[] = "Недопустимый тип файла " . $fileName;
            continue;
        }
        $filePath = UPLOAD_DIR . '/' . basename($fileName);

        if (!move_uploaded_file($_FILES['files']['tmp_name'][$i], $filePath)) {
            $errors[] = "Ошибка загрузки файла "  . $fileName;
            continue;
        }

        $filePathPreview = UPLOAD_DIR . '/preview/' . basename($fileName);
        include_once("smart_resize_image.php");
        smart_resize_image($filePath, null, 200, 200, true, $filePathPreview, false, false, 100, false);



        $success++;
    }
}
?>

<html>

<head>
    <title>Загрузить картинку</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>


<body>
    <div class="container">
        <div class="formblock">
            <h2>Добавить картинку</h2>

            <?php
            if (!empty($success)) {
                echo "<div class=\"message\">Успешно загружено файлов: $success</div>";
            }
            if (!empty($errors)) :
                foreach ($errors as $error) : ?>
                    <div class="message"><?php echo $error ?> </div>
            <?php
                endforeach;
            endif;
            ?>

            <form method='post' action="/add.php" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
                <input type='file' name='files[]' class='file-drop' id='file-drop' multiple required><br>
                <input type='submit' value='Загрузить'>
            </form>

            <div class='message-div message-div_hidden' id='message-div'></div>

            <a href="index.php">Вернуться в галерею</a>
        </div>
    </div>
</body>

</html>