<?php
include('functions.php');
if ( empty($_SESSION['users']) ) {
	header('Location: signin.html');
	die();
}
$deleteOperation = deleteOperation(
  /*   $_POST['idCompte'], */
    $_POST['id']
	);
	header('Location: dashboard.php');
?>