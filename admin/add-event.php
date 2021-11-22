<?php

//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");

//if user Actually clicked Add Post Button
if(isset($_POST)) {

	$event_name = mysqli_real_escape_string($conn, $_POST['event']);
  $event_desc = mysqli_real_escape_string($conn, $_POST['description']);

	$category_id = mysqli_real_escape_string($conn, $_POST['categoryname']);
	
	$date = $_POST['date'];
	$date = date("Y-m-d",strtotime($date));
	$event_date =  mysqli_real_escape_string($conn,	$date);

	if(isset($_POST['enableevent']))
		$enable_event = 1;
	else  
		$enable_event = 0;

	if(isset($_POST['featuredevent']))
		$featuredevent = 1;
	else  
		$featuredevent = 0;

	// check image
	if(!empty($_FILES["image"]["name"])) { 
		// Get file info 
		$fileName = basename($_FILES["image"]["name"]); 
		$fileType = pathinfo($fileName, PATHINFO_EXTENSION); 		 
		// Allow certain file formats 
		$allowTypes = array('jpg','png','jpeg','gif'); 
		if(in_array($fileType, $allowTypes)){ 
				$image = $_FILES['image']['tmp_name']; 
				$imgContent = file_get_contents($image); 
				// addslashes()
				
		}else{ 
				$statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
		} 
}

	// New way using prepared statements. This is safe from SQL INJECTION. Should consider to update to this method when many people are using this method.

	$stmt = $conn->prepare("INSERT INTO events(name, description, e_date, e_category, e_isEnabled, e_Featured, e_image) VALUES (?, ?, ?, ?, ?, ?, ?)");

	$stmt->bind_param("sssiiis", $event_name, $event_desc, $event_date,  $category_id, $enable_event, $featuredevent, $imgContent);

	if($stmt->execute()) {
		//If data Inserted successfully then redirect to dashboard
		$_SESSION['addEventSuccess'] = true;
		header("Location: event.php");
		exit();
	} else {
		//If data failed to insert then show that error. Note: This condition should not come unless we as a developer make mistake or someone tries to hack their way in and mess up :D
		print $conn->error;
		
	}

	$stmt->close();

	//Close database connection. Not compulsory but good practice.
	$conn->close();

} else {
	//redirect them back to dashboard page if they didn't click Add Post button
	header("Location: dashboard2.php");
	exit();
}