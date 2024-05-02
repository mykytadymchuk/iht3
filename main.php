<?php
    if(!isset($_COOKIE['username'])) {
        header('Location: loginPage.php');
    }
    else {
        $username = $_COOKIE['username'];
        include("connect.php");
        $contactCount = $dataCollection->count(['username' => "$username"]);
    }
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Телефонна книга</title>
    <link rel="stylesheet" href="stylesMain.css">
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
    <div  id="deleteAccountButton">
        <a href='deleteAccountProcess.php'>Видалити акаунт</a>
    </div>
    <div id=contactAddBlock>
        <form action=contactAdd.php method=post>
            <input type=submit value=+ id=contactAddButton>
        </form>
        <form action="search.php" method=post>
            <label for="searchType" id="searchTypeLabel">Параметр пошуку</label>
            <select name="searchType" id="searchType">
                <?php
                    $contactsCursor = $dataCollection->find(['username' => "$username"]);
                    $keyArray = [];
                    foreach ($contactsCursor as $element) {
                        foreach ($element as $key => $value) {
                            if (!in_array($key, $keyArray)) {
                                array_push($keyArray, $key);
                            }
                        }
                    }
                    for ($i=2; $i < count($keyArray); $i++) {
                       echo "<option value='$i'>$keyArray[$i]</option>"; 
                    }
                ?>
            </select>
            <input type="text" name="searchField" id="searchField">
            <input type=submit value="ОК" id=searchTypeButton>
        </form>
        
    </div>
    <?php
        if ($contactCount==0) {
            echo "<h3 id=contactNone> У вас немає жодного контакту!</h3>";
        }
        else {
            $contactsCursor = $dataCollection->find(['username' => "$username"]);
            foreach ($contactsCursor as $element) {
                $keyArray = [];
                $valueArray = [];
                foreach ($element as $key => $value) {
                    array_push($keyArray, $key);
                    array_push($valueArray, $value);
                }
                $id = $valueArray[0];
                echo "<div id=contact>";
                echo "<h3 id=name>$valueArray[2]</h3> <br>";
                for ($i=3; $i < count($keyArray); $i++) { 
                    echo "<b>$keyArray[$i]:</b> $valueArray[$i] <br>";
                }
                echo "<br><a href=contactEdit.php?contactId=$id>Редагувати</a>";
                echo "<br><a href=deleteContactProcess.php?contactId=$id>Видалити</a>";
                echo "</div>";
            }
        }
    ?>
    <div id="logoutBlock">
        <a href="logoutProcess.php">Вийти</a>
    </div>
    <div id="deleteAccountBlock">
        
    </div>
</body>
</html>