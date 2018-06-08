<?php
include('functions.php');
if ( empty($_SESSION['users']) ) {
	header('Location: signin.html');
	die();
}

$error = false;

$verifyAccounts = verifyMaxAccount($_SESSION['users']['id']);

if ( !empty($_POST['name']) AND (!empty($_POST['amount'])) AND ($verifyAccounts < 10)){
	$insert_account = addAccount(
	$_POST['name'],
	$_POST['amount'],
    $_POST['currency'],
	$_SESSION['users']['id'],
    $_POST['type']
	);
	header("Location:" . $_SERVER['HTTP_REFERER']);
	die();
}
else {
	header("Location:" . $_SERVER['HTTP_REFERER']);
}
?>