<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $contactName = $_POST['contactName'];
        $contactNumber = $_POST['contactNumber'];
        
        $username = $_COOKIE['username'];

        $numberIsPresent = false;
        $contactIsPresent = false;

        include("connect.php");

        $cursor = $dataCollection->find(['username' => "$username", 'ПІБ' => "$contactName"], [
            'projection' => ['ПІБ' => 1, '_id' => 0]
        ]);

        foreach ($cursor as $element) {
            if ($element['ПІБ'] != NULL) {
                $contactIsPresent = true;
            }
        };

        if($contactIsPresent == false) {
            $cursor = $dataCollection->find(['username' => "$username", 'Номер телефону' => "$contactNumber"], [
                'projection' => ['Номер телефону' => 1, '_id' => 0]
            ]);
    
            foreach ($cursor as $element) {
                if ($element['Номер телефону'] != NULL) {
                    $numberIsPresent = true;
                }
            };
        }

        if ($contactIsPresent == true) {
            setcookie('error', 1); // Контакт з таким ім'ям вже існує!
            header('Location: contactAdd.php');
        }
        elseif ($numberIsPresent == true) {
            setcookie('error', 2); // Контакт з таким номером телефону вже існує!
            header('Location: contactAdd.php');
        }
        else {
            $dataCollection->insertOne(['username' => "$username",
            'ПІБ' => "$contactName", 'Номер телефону' => "$contactNumber"]);

            header('Location: main.php');
        }
    }
?>