<?php
    if(!isset($_COOKIE['username'])) {
        header('Location: loginPage.php');
    }
    else {
        $username = $_COOKIE['username'];

        if(isset($_COOKIE['error'])) {
            if($_COOKIE['error']=='1') {
                echo '<script type="text/javascript">';
                echo 'alert("Контакт з таким імям вже існує!");';
                echo '</script>';
            }
            
            elseif($_COOKIE['error']=='2') {
                echo '<script type="text/javascript">';
                echo 'alert("Контакт з таким номером телефону вже існує");';
                echo '</script>';
            }
    
            setcookie('error', '', time() - 3600);
        }
    }
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати контакта</title>
    <link rel="stylesheet" href="stylesAddContact.css">
</head>
<body>
    <header>
        <h1 id="phonebookTitle" class="headerElement">Телефонна книга</h1>
        <h2 id="usernameBlock" class="headerElement">
            <?php
                echo("Вітаю, $username!");
            ?>
        </h2>
    </header>
    <div id=contactAddBlock>
        <form action=contactAddProcess.php method=post>

            <div id="contactBlock">
                <label for="contactElement">ПІБ</label> <br>
                <input type="text" name="contactName" id="contactElement" required autofocus> <br>
            </div>

            <div id="contactBlock">
                <label for="contactElement">Номер телефону</label> <br>
                <input type="tel" name="contactNumber" id="contactElement" placeholder="+380ХХХХХХХХХ" pattern="\+380\d{9}" required> <br>
            </div>

            <input type=submit value=Додати id=contactAddButton>
        </form>
    </div>
    <div id="cancelBlock">
        <a href="main.php">Скасувати</a>
    </div>
    </body>
</html>