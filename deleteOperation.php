<?php
include('functions.php');
if ( empty($_SESSION['users']) ) {
	header('Location: signin.html');
	die();
}
$deleteOperation = deleteOperation(
    $_POST['id'],
    $_POST['idCompte']
	);
	header("Location:" . $_SERVER['HTTP_REFERER']);
?>