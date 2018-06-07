<?php

function connexionDb(){
    $dsn = 'mysql:host=localhost;dbname=local';
    $user = 'root';
    $pass = 'calories139';
    $pdo = new PDO($dsn, $user, $pass);
    return $pdo;
}