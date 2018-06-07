<?php
include('functions.php');
if ( empty($_SESSION['users']) ) {
	header('Location: signin.html');
	die();
}

$deleteAccount = deleteAccount(
    $_POST['compteId']
	);
	header('Location: dashboard.php');
?>