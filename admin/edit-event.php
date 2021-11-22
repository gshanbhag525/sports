<?php

session_start();

if(empty($_SESSION['id_admin'])) {
	header("Location: index.php");
	exit();
}


require_once("../db.php");

if(isset($_POST)) {

	$stmt = $conn->prepare("UPDATE events SET name=?, description=?, e_date=?, e_image, e_category,
    e_isEnabled, e_Featured WHERE event_id=?");
  // add data typesfor all fielsd in bind param
	$stmt->bind_param("ssi", $_POST['event_name'],  $_POST['event_id']);

  // $js_code = 'console.log(' . json_encode($_POST['category_name'], JSON_HEX_TAG) . 
  // ');';

  // $js_code1 = 'console.log(' . json_encode($_POST['category_id'], JSON_HEX_TAG) . 
  // ');';  

  // echo  $js_code;
  // echo $js_code1;

	$event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
	$event_name = mysqli_real_escape_string($conn, $_POST['event_name']);

	if($stmt->execute()) {
		//If data Updated successfully then redirect to dashboard

		$_SESSION['eventUpdateSuccess'] = true;
		header("Location: event.php");
		exit();
	} else {
		//If data failed to insert then show that error. Note: This condition should not come unless we as a developer make mistake or someone tries to hack their way in and mess up :D
		echo "Error " . $sql . "<br>" . $conn->error;
	}

	$stmt->close();

	//Close database connection. Not compulsory but good practice.
	$conn->close();

}else {
	//redirect them back to dashboard page if they didn't click Edit Post button
	header("Location: dashboard2.php");
	exit();
}
