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
            foreach ($cursor as $element) {
                if ($element['username'] != NULL) {
                    $userIsPresent = true;
                }
            };

            if ($userIsPresent === true) { // Користувач існує
                setcookie('error', 1); // Користувач з таким логіном вже існує!
                header('Location: signupPage.php');
            }

            else {  // Користувача не існує
                if (isset($_POST['password'])) {
                    $password = $_POST['password'];
                    $cursor = $userCollection->insertOne(['username' => "$username",
                    'password' => "$password"]);
                    setcookie('username', $username, time() + 3600);
                    setcookie('sort', 'ПІБ', time() + 3600);
                    header('Location: main.php');
                }
            }
        }
    }
?>