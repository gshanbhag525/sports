<?php

//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");

//if user Actually clicked Add Post Button
if(isset($_POST)) {

	// New way using prepared statements. This is safe from SQL INJECTION. Should consider to update to this method when many people are using this method.

	$stmt = $conn->prepare("INSERT INTO categories(name) VALUES ( ?)");

	$stmt->bind_param("s", $category);

	$category = mysqli_real_escape_string($conn, $_POST['category']);
	

	if($stmt->execute()) {
		//If data Inserted successfully then redirect to dashboard
		$_SESSION['addCategorySuccess'] = true;
		header("Location: category.php");
		exit();
	} else {
		//If data failed to insert then show that error. Note: This condition should not come unless we as a developer make mistake or someone tries to hack their way in and mess up :D
		echo "Error ";
	}

	$stmt->close();

	//THIS IS NOT SAFE FROM SQL INJECTION BUT OK TO USE WITH SMALL TO MEDIUM SIZE AUDIENCE

	//Insert Job Post Query 
	// $sql = "INSERT INTO job_post(id_company, jobtitle, description, minimumsalary, maximumsalary, experience, qualification) VALUES ('$_SESSION[id_user]','$jobtitle', '$description', '$minimumsalary', '$maximumsalary', '$experience', '$qualification')";

	// if($conn->query($sql)===TRUE) {
	// 	//If data Inserted successfully then redirect to dashboard
	// 	$_SESSION['jobPostSuccess'] = true;
	// 	header("Location: dashboard.php");
	// 	exit();
	// } else {
	// 	//If data failed to insert then show that error. Note: This condition should not come unless we as a developer make mistake or someone tries to hack their way in and mess up :D
	// 	echo "Error " . $sql . "<br>" . $conn->error;
	// }

	//Close database connection. Not compulsory but good practice.
	$conn->close();

} else {
	//redirect them back to dashboard page if they didn't click Add Post button
	header("Location: dashboard2.php");
	exit();
}