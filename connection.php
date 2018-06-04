<?php
include('./functions.php');
$connexion=signIn(
	$_POST['email'],
	$_POST['password']
	);
if ( $connexion == 1 ) {	
	$_SESSION['users'] = $connexion[0];
	 header('Location: dashboard.php');
} else {
	header('Location: signin.php');
}