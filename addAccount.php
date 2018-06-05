<?php
include('functions.php');
if ( empty($_SESSION['users']) ) {
	header('Location: signin.html');
	die();
}
if ( !empty($_POST['name']) AND (!empty($_POST['amount'])) ){
	$insert_account = addAccount(
	$_POST['name'],
	$_POST['amount'],
    $_POST['currency'],
	$_SESSION['users']['id'],
    $_POST['type']
	);
	header('Location: dashboard.php');
	die();
}
else {
    var_dump('Error');
	//header('Location: dashboard.php');
}
?>