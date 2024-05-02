<?php
    require_once __DIR__ . '/vendor/autoload.php';
    $userCollection = (new MongoDB\Client)->phonebook->users;
    $dataCollection = (new MongoDB\Client)->phonebook->data;
?>