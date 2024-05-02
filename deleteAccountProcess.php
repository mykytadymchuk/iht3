<?php
    $username = $_COOKIE['username'];
    include("connect.php");

    $cursor = $userCollection->find(['username' => "$username"], [
        'projection' => ['username' => 1, '_id' => 0]
    ]);

    $userIsPresent = false;
    foreach ($cursor as $element) {
        if ($element['username'] != NULL) {
            $userIsPresent = true;
        }
    };

    if ($userIsPresent == true) { // Користувач існує
        $dataCollection->deleteMany(['username' => "$username"]);
        $userCollection->deleteOne(['username' => "$username"]);
        setcookie('username', '', time() - 3600);
        header('Location: loginPage.php');
    }

    else {  // Користувача не існує
        setcookie('error', 2);
        header('Location: loginPage.php');
    }
?>