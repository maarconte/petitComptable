<?php

require('./db.php');
$pdo = connexionDb();

    function getCategories(){
        global $pdo;
        $req = $pdo->prepare("SELECT * FROM category");
        $req->execute(array());
        return $req->fetchAll();
      }
    
    function getOperations(){
        global $pdo;
        $req = $pdo->prepare("SELECT * FROM operations");
        $req->execute(array());
        return $req->fetchAll();
      }
    
    function getComptes(){
        global $pdo;
        $req = $pdo->prepare("SELECT * FROM comptes");
        $req->execute(array());
        return $req->fetchAll();
      }
    
    function verifyEmail($email){
        global $pdo;
        $req = $pdo->prepare("SELECT * FROM users WHERE email=:email;");
        $req->execute([
            ':email'=>$email
            ]);
        return $req->fetchAll(); 
    }
    
      function signUp($pseudo,$email,$password)
      {
        global $pdo;
          $req = $pdo->prepare('INSERT INTO users ( pseudo, email, password ) 
              VALUES (:pseudo, :email, :password);');
          $req->execute([
              ':pseudo'=> $pseudo,
              ':email'=> $email,
              ':password'=> $password
              ]);
}

function signIn($email,$password){
    global $pdo;
    $req=$pdo->prepare('SELECT * FROM users WHERE email=:email AND password = :password;');
    $req->execute([
        ':email'=> $email,
        ':password'=> $password
        ]);
    return $req->rowCount();
}