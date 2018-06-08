<?php
session_start();
require('./db.php');
$pdo = connexionDb();
 
/*=============================================
 =            User                          =
 =============================================*/
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
              VALUES (:pseudo, :email, AES_ENCRYPT(:password)');
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
 /*=============================================
 =            Comptes                          =
 =============================================*/
 function getComptes(){
    global $pdo;
    $req = $pdo->prepare("SELECT * FROM comptes");
    $req->execute(array());
    return $req->fetchAll();
  }

  function verifyMaxAccount($id){
    global $pdo;
    $request=$pdo->prepare('SELECT COUNT(id) as count FROM comptes WHERE idUser = :id');
    $request->execute([
        ':id'=> $id
        ]);
    return $request->fetchAll()[0]['count'];

  }

 function addAccount( $name, $amount, $currency, $idUser, $type)
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

function selectCompte($id)
{
    global $pdo;
    $request=$pdo->prepare('SELECT * FROM comptes WHERE id = :id ;');
    $request->execute([
        ':id'=> $id
    ]);
    return $request->fetchAll();
}

function selectAccount($idUser)
{
    global $pdo;
    $request=$pdo->prepare('SELECT * FROM comptes WHERE idUser=:idUser;');
    $request->execute([":idUser" => $idUser]);
    return $request->fetchAll();   
}

function deleteAccount($id){
    global $pdo;
    $request=$pdo->prepare('DELETE FROM operations WHERE idCompte = :id');
    $request->execute([
        ':id'=> $id
    ]); 
    $request=$pdo->prepare('DELETE FROM comptes WHERE id = :id ');
    $request->execute([
        ':id'=> $id
    ]); 

}

function update($id, $name){
    global $pdo;
    $request=$pdo->prepare("UPDATE comptes SET name = :name WHERE id = :id");
    $request->execute([
        ':name'=> $name,
        ':id'=> $id
        ]);
}

 /*=============================================
 =            Operations                       =
 =============================================*/

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
        /* Mettre à jour le solde du compte */
    $request=$pdo->prepare("UPDATE comptes SET comptes.amount = comptes.amount + (
        SELECT (CASE type WHEN 'credit' THEN :amount ELSE :amount * -1 END) 
        FROM operations o, category c
        WHERE c.id = o.idCategory 
        ORDER BY date DESC LIMIT 1) WHERE comptes.id = :idCompte");
    $request->execute([
        ':amount'=> $amount,
        ':idCategory'=> $idCategory,
        ':idCompte'=> $idCompte
        ]);
    return $request->fetchAll();
}

function selectOperations($idCompte){
    global $pdo;
    $request=$pdo->prepare('SELECT * FROM operations WHERE idCompte = :idCompte ORDER BY date DESC ;');
    $request->execute([
        ':idCompte'=> $idCompte
    ]);
    return $request->fetchAll();
}

function selectLastOperation($idCompte){
    global $pdo;
    $request=$pdo->prepare('SELECT * FROM operations WHERE idCompte = :idCompte ORDER BY date DESC LIMIT 1');
    $request->execute([
        ':idCompte'=> $idCompte
    ]);
    return $request->fetchAll();
}

function deleteOperation($idOp, $idCo) {
    global $pdo;
    $request=$pdo->prepare(" UPDATE comptes SET comptes.amount = comptes.amount - (
        SELECT (CASE type WHEN 'debit' THEN o.amount *-1 ELSE o.amount END)
        FROM operations o, category c 
        WHERE o.id = :idOp AND o.idCategory = c.id )
    WHERE comptes.id = :idCo ");
        $request->execute([
            ':idCo'=> $idCo,
            ':idOp' => $idOp
        ]);
    $request=$pdo->prepare('DELETE FROM operations WHERE id = :idOp ;');
    $request->execute([
        ':idOp'=> $idOp
    ]);
}

function iconPaymentMethod($payment){
    switch($payment){
        case "CB";
            echo "far fa-credit-card";
            break;

        case "Virement";
            echo "fas fa-share";
            break;
            default : 
            echo "far fa-money-bill-alt";
    }
}

function updateOp($id, $name){
    global $pdo;
    $request=$pdo->prepare("UPDATE operations SET name = :name WHERE id = :id");
    $request->execute([
        ':name'=> $name,
        ':id'=> $id
        ]);
}

 /*=====  End of Operations                ======*/


/*=============================================
 =            Categories                       =
 =============================================*/

 function selectCategories()
{
    global $pdo;
    $request=$pdo->prepare('SELECT * FROM category ;');
    $request->execute([]);
    return $request->fetchAll();
}

function selectCategory($id){
    global $pdo;
    $request=$pdo->prepare('SELECT * FROM category WHERE id = :id ;');
    $request->execute([
        ':id'=> $id
    ]);
    return $request->fetchAll();
}

function iconCategory($idCategory) {
    switch ($idCategory) {
        case 1 :
            echo "fas fa-utensils";
            break;
        case 2 :
            echo "fas fa-cart-plus";
            break;
        case 3 :
            echo "fas fa-football-ball";
            break;
        case 4 :
            echo "fas fa-subway";
            break;
        case 5 :
            echo "fas fa-home";
            break;
        case 6 :
            echo "fas fa-question-circle";
            break;
        case 7 :
            echo "fas fa-share";
            break;
        case 8 :
            echo "fas fa-share";
            break;
        case 9 :
            echo "fas fa-money-check";
            break;
        case 10 :
            echo "fas fa-question-circle";
            break;
    }
}
 /*=====  End of Categories  ======*/

 /* Selectionner colonne */
function get_enum_values( $table, $column_name)
{
    global $pdo;
    // Récupérer la colonne de type ENUM et lui retirer le text 'enum' dans l'objet
    $result = $pdo->query("SELECT SUBSTR(COLUMN_TYPE, 5) FROM INFORMATION_SCHEMA.COLUMNS
       WHERE TABLE_NAME = '$table' AND COLUMN_NAME = '$column_name'");
   //$result->execute([]);
   // Initialisation d'un tableau
   $row = array();
   // Récuperer ce qui correspond à mon regex et le ranger dans un taleau
   preg_match_all("/([^'^(^)^,]+)/", $result->fetch()[0],$row);
    return $row[0];
}

$verifyAccounts = verifyMaxAccount($_SESSION['users']['id']);