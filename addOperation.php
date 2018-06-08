<?php
include('./functions.php');
if ( empty($_SESSION['users']) ) {
	header('Location: signin.html');
	die();
}
if ( !empty($_POST['name']) AND (!empty($_POST['amount'])) ){

	$insert_operation = addOperation(
	
	$_POST['name'],
	$_POST['amount'],
	$_POST['idCategory'],
	$_POST['paymentMethod'],
    $_POST['idCompte'],
    $_SESSION['users']['id']
	);
	header("Location:" . $_SERVER['HTTP_REFERER']);
}
else {
	header('Location: dashboard.php');
}
?>