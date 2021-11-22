<?php

session_start();

if(empty($_SESSION['id_admin'])) {
	header("Location: index.php");
	exit();
}


require_once("../db.php");

if(isset($_GET)) {

	//Delete Users data using id and redirect
	$sql = "DELETE FROM events WHERE event_id='$_GET[id]'";
	if($conn->query($sql)) {
		header("Location: event.php");
		exit();
	} else {
		echo "Error";
	}
}