<?php
    if(!isset($_COOKIE['username'])) {
        header('Location: loginPage.php');
    }
    else {
        $username = $_COOKIE['username'];
        $contactId = $_GET['contactId'];
        $contactId = new MongoDB\BSON\ObjectId("$contactId");
        include("connect.php");
        $contactsCursor = $dataCollection->find(['_id' => $contactId]);

        foreach ($contactsCursor as $element) {
            $id = $element['_id'];
            $name = $element['ПІБ'];
            $number = $element['Номер телефону'];
        }

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
    <title>Редагувати контакта</title>
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
        <?php 
            echo "<form action='contactEditProcess.php?contactId=$contactId' method=post>";
        ?>
            <div id="contactBlock">
                <label for="contactElement">ПІБ</label> <br>
                <?php 
                    echo"<input type='text' name='contactName' id='contactElement' value='$name' required autofocus> <br>";
                ?>
            </div>

            <div id="contactBlock">
                <label for="contactElement">Номер телефону</label> <br>
                <?php 
                    echo"<input type='tel' name='contactNumber' id='contactElement' placeholder='+380ХХХХХХХХХ' pattern='\+380\d{9}' value='$number' required> <br>";
                ?>
            </div>

            <?php
                $contactsCursor = $dataCollection->find(['_id' => $contactId]);
                foreach ($contactsCursor as $element) {
                    $keyArray = [];
                    $valueArray = [];
                    foreach ($element as $key => $value) {
                        array_push($keyArray, $key);
                        array_push($valueArray, $value);
                    }
                    for ($i=4; $i < count($keyArray); $i++) { 
                        echo "<div id='contactBlock'>";
                        echo "<label for='contactElement'>$keyArray[$i]</label> <br>";
                        echo "<input type='text' name='$i' id='contactElement' value='$valueArray[$i]'>";
                        echo "</div>";
                    }
                }
            ?>

            <div id="contactBlock">
                <h2>Додати нове поле</h2>
                <label for="newFieldName">Назва поля</label> <br>
                <input type='text' name='newFieldName' id='contactElement'> <br>
                <label for="newFieldValue">Значення поля</label> <br>
                <input type='text' name='newFieldValue' id='contactElement'> <br>
            </div>

            <br> <br> <br> <br>

            <input type=submit value=Змінити id=contactAddButton>
        </form>
    </div>
    <div id="cancelBlock">
        <a href="main.php">Скасувати</a>
    </div>
    </body>
</html>