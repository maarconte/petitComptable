<?php
session_start();
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
    return $req->fetchAll();
}

/* Ajouter compte */
function addAccount( $name, $amount,  $currency, $idUser, $type)
{
    global $pdo;
    $request=$pdo->prepare('INSERT INTO  comptes ( name,amount, currency, idUser, type) 
    VALUES (:name, :amount,:currency, :idUser,:type);');
    $request->execute([
        ':name'=> $name,
        ':amount'=> $amount,
        ':currency'=> $currency,
        ':idUser'=> $idUser,
        ':type'=> $type
        ]);
    return $request->fetchAll();
}

/* Selectionner un compte */
function selectAccount($idUser)
{
    global $pdo;
    $request=$pdo->prepare('SELECT * FROM comptes WHERE idUser=:idUser;');
    $request->execute([":idUser" => $idUser]);
    return $request->fetchAll();   
}

/* Selectionner colonne */
function get_enum_values( $table, $column_name)
{
    global $pdo;
    // Récupérer la colonne de type ENUM et lui retirer le text 'enum' dans l'objet
    $result = $pdo->prepare("SELECT SUBSTR(COLUMN_TYPE, 5) FROM INFORMATION_SCHEMA.COLUMNS
       WHERE TABLE_NAME = '$table' AND COLUMN_NAME = '$column_name'");
   $result->execute([]);
   // Initialisation d'un tableau
   $row = array();
   // Récuperer ce qui correspond à mon regex et le rangerr dans un taleau
   preg_match_all("/([^'^(^)^,]+)/", $result->fetch()[0],$row);
    return $row[0];
}

/* Ajouter operation */
function addOperation( $name, $amount,$idCategory, $paymentMethod, $idCompte, $idUser)
{
    global $pdo;
    $request=$pdo->prepare('INSERT INTO  operations ( name,amount,idCategory,paymentMethod, idCompte, date ) 
    VALUES (:name, :amount,:idCategory,:paymentMethod,:idCompte, now());');
    $request->execute([
        ':name'=> $name,
        ':amount'=> $amount,
        ':idCategory'=> $idCategory,
        ':paymentMethod'=>$paymentMethod,
        ':idCompte'=> $idCompte,
        ]);
    $request=$pdo->prepare("UPDATE comptes SET comptes.amount = comptes.amount + (
        SELECT (CASE type WHEN 'credit' THEN o.amount ELSE o.amount * -1 END) 
        FROM operations o, category c 
        WHERE idUser = :idUser AND c.id = o.idCategory 
        ORDER BY o.date DESC LIMIT 1) WHERE idCompte = :idCompte");
    $request->execute([
        ':amount'=> $amount,
        ':idCategory'=> $idCategory,
        ':idCompte'=> $idCompte
        ]);
    return $request->fetchAll();
}

/* Selectionner les catégories */
function selectCategories()
{
    global $pdo;
    $request=$pdo->prepare('SELECT * FROM category ;');
    $request->execute([]);
    return $request->fetchAll();
}

function selectCompte($id)
{
    global $pdo;
    $request=$pdo->prepare('SELECT * FROM comptes WHERE id = :id ;');
    $request->execute([
        ':id'=> $id
    ]);
    return $request->fetchAll();
}

function selectOperations($idCompte){
    global $pdo;
    $request=$pdo->prepare('SELECT * FROM operations WHERE idCompte = :idCompte ;');
    $request->execute([
        ':idCompte'=> $idCompte
    ]);
    return $request->fetchAll();
}

function selectCategory($idCategory){
    global $pdo;
    $request=$pdo->prepare('SELECT name FROM categories, operations WHERE categories.id = :idCategory ;');
    $request->execute([
        ':idCategory'=> $idCategory
    ]);
    return $request->fetchAll();
}
