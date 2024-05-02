<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $contactId = $_GET['contactId'];
        $contactId = new MongoDB\BSON\ObjectId("$contactId");
        $contactName = $_POST['contactName'];
        $contactNumber = $_POST['contactNumber'];
        $username = $_COOKIE['username'];

        $numberIsPresent = false;
        $contactIsPresent = false;

        include("connect.php");

        $cursor = $dataCollection->find(['username' => "$username", 'ПІБ' => "$contactName"]);

        foreach ($cursor as $element) {
            if ($element['ПІБ'] != NULL) {
                if($element['_id']!=$contactId) {
                    $contactIsPresent = true;
                }
            }
        };

        if($contactIsPresent == false) {
            $cursor = $dataCollection->find(['username' => "$username", 'Номер телефону' => "$contactNumber"]);
    
            foreach ($cursor as $element) {
                if ($element['Номер телефону'] != NULL) {
                    if($element['_id']!=$contactId) {
                        $numberIsPresent = true;
                    }
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
            $dataCollection->updateOne(['username' => "$username",
                '_id' => $contactId], ['$set' => ['ПІБ' => $contactName, 'Номер телефону' => $contactNumber]]);

            $contactsCursor = $dataCollection->find(['_id' => $contactId]);

            foreach ($contactsCursor as $element) {
                $keyArray = [];
                foreach ($element as $key => $value) {
                    array_push($keyArray, $key);
                }

                $valueArray = [];
                for ($i=4; $i < count($keyArray); $i++) {
                    $valueArray[$i] = $_POST["$i"];
                }
                
                for ($i=4; $i < count($keyArray); $i++) {
                    if ($_POST["$i"] != NULL) {
                        $dataCollection->updateOne(['username' => "$username",
                            '_id' => $contactId], ['$set' => ["$keyArray[$i]" => $valueArray[$i]]]);
                    }
                    else {
                        $dataCollection->updateOne(['username' => "$username",
                        '_id' => $contactId], ['$unset' => ["$keyArray[$i]" => $valueArray[$i]]]);
                    }
                    
                }
            
            }

            if (isset($_POST['newFieldName']) && $_POST['newFieldValue'] != NULL) {
                if (isset($_POST['newFieldValue']) && $_POST['newFieldValue'] != NULL) {
                    $newFieldName = $_POST['newFieldName'];
                    $newFieldValue = $_POST['newFieldValue'];
                    $dataCollection->updateOne(['username' => "$username",
                        '_id' => $contactId], ['$set' => [$newFieldName => $newFieldValue]]);
                }
            }

          header('Location: main.php');
        }

    }
?>