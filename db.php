<?php

function connexionDb(){
    $dsn = 'mysql:host=localhost;dbname=local';
    $user = 'root';
    $pass = '';
    $pdo = new PDO($dsn, $user, $pass);
    return $pdo;
}