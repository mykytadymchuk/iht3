<?php
    if(!isset($_COOKIE['username'])) {
        header('Location: loginPage.php');
    }
    else {
        $username = $_COOKIE['username'];
        include("connect.php");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['searchType'])) {
                $contactsCursor = $dataCollection->find(['username' => "$username"]);
                $keyArray = [];
                foreach ($contactsCursor as $element) {
                    foreach ($element as $key => $value) {
                        if (!in_array($key, $keyArray)) {
                            array_push($keyArray, $key);
                        }
                    }
                }

                $searchIndex = $_POST['searchType'];
                $searchCriteria = $keyArray[$searchIndex];
                $searchValue = $_POST['searchField'];

                $filter = ['username' => "$username", "$searchCriteria" => ['$regex' => '.*'.$searchValue.'.*', '$options' => 'i']];
                $contactsCursor = $dataCollection->find($filter);
            }
        }
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
    <?php
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
    ?>
    <div id="cancelBlock">
        <a href="main.php">Скасувати</a>
    </div>
</body>
</html>