<?php
    if(isset($_COOKIE['username'])) {
        header('Location: main.php');
    }

    if(isset($_COOKIE['error'])) {
        echo '<script type="text/javascript">';
        echo 'alert("Користувач з таким логіном вже існує!");';
        echo '</script>';
        setcookie('error', '', time() - 3600);
    }
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація</title>
    <link rel="stylesheet" href="stylesAuth.css">
</head>
<body>
    <h1 id="phonebookTitle">Телефонна книга</h1>
    <div id="mainBlock">
        <h2 id="pageTitle">Реєстрація</h1>
        <form action="signupProcess.php" method="post">
            <div id="usernameBlock">
                <label for="username">Логін</label><br>
                <input type="text" name="username" id="username" required> <br>
            </div>
            <div id="passwordBlock">
                <label for="password">Пароль</label><br>
                <input type="password" name="password" id="password" required>
            </div>
            <div id="submitBlock">
                <input type="submit" value="ОК" id="submit">
            </div>
        </form>
    </div>
    <div id="noAccount">
        <a href="loginPage.php">У мене вже є акаунт</a> 
    </div>
</body>
</html>