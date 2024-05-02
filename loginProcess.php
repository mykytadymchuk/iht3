<?php
    include("connect.php");
    //error_reporting(0);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['username'])) {
            $username = $_POST['username'];

            $cursor = $userCollection->find(['username' => "$username"], [
                'projection' => ['username' => 1, 'password' => 1, '_id' => 0]
            ]);

            $userIsPresent = false;
            $dbPassword = "";
            foreach ($cursor as $element) {
                if ($element['username'] != NULL) {
                    $userIsPresent = true;
                }
                $dbPassword = $element['password'];
            };

            if ($userIsPresent === true) { // Користувач існує
                if (isset($_POST['password'])) {
                    $password = $_POST['password'];
                    if ($dbPassword === $password) {
                        setcookie('username', $username, time() + 3600);
                        header('Location: main.php');
                    }
                    else {
                        setcookie('error', 1); // Неправильний логін або пароль!
                        header('Location: loginPage.php');
                    }
                }
            }

            else {  // Користувача не існує
                setcookie('error', 1); // Неправильний логін або пароль!
                header('Location: loginPage.php');
            }
        }
    }
?>