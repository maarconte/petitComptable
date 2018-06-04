<?php
include('./functions.php');
if ( $_POST['password'] !== $_POST['password1'] ) {
    //header('Location: error-password.html');
	die();
}

$verifyEmail = verifyEmail(
	$_POST['email']
    );
    
if ( count($verifyEmail) > 0 ) {
    //header('Location: error-email.html');
	die();
} else {
$inscription = signUp(
	$_POST['pseudo'],
	$_POST['email'],
	$_POST['password']
	);
}
header('Location: signin.php');