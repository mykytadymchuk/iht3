<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $username = $_COOKIE['username'];
        $contactId = $_GET['contactId'];
        $contactId = new MongoDB\BSON\ObjectId("$contactId");

        include("connect.php");
        $dataCollection->deleteOne(['username' => "$username", '_id' => $contactId]);
        header('Location: main.php');
    }
?>