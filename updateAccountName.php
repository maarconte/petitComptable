<?php
include('functions.php');
if ( empty($_SESSION['users']) ) {
	header('Location: signin.html');
	die();
}
$updateName = update(
    $_POST['id'],
    $_POST['name']
	);
	header("Location:" . $_SERVER['HTTP_REFERER']);
?>