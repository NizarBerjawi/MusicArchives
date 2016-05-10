<!DOCTYPE html>
<html>
<head>
	<title>Music Archives</title>
</head>
<body>
	<?php 

	date_default_timezone_set('Australia/Brisbane');

	session_start();  

	$user = $_POST["user"];
	$pass = $_POST["pass"];

	// Need the database connection:
	require ('mysqli_connect.php');

	/* Prepare the query to verify the user ID */
	$query = "SELECT * FROM Admin WHERE Admin_Email=? AND Admin_Password=?";
	$stmt = $mysqli->stmt_init();
	$stmt->prepare($query);
	$stmt->bind_Param('ss', $user, $pass);

	/* execute prepared statement */
	$stmt->execute();

	/* Get the result*/
	$result = $stmt->get_result();
	$row = $result->fetch_array();
	$Admin_Privilege = $row['Admin_Privilege'];
	$Admin_ID = $row['Admin_ID'];

	/* close statement */
	$stmt->close();

	/* Store user information in SESSION */
	if ($Admin_ID) { 

		$_SESSION['user'] = $user;
		$_SESSION['pass'] = $pass;
		$_SESSION['Admin_ID'] = $Admin_ID;
		$_SESSION['Admin_Privilege'] = $Admin_Privilege;

		/* Connect to the database to insert data */
		$con = mysqli_connect('localhost', 'deco3800', '19930728');
		//This connection is needed for local testing purposes
		//$conn = mysqli_connect('localhost', 'root', '');
		$db = mysqli_select_db($con, 'convict_records');

		$time = time();
		$date = date('y-m-d h:i:s',time());

		/* Insert login information into database*/
		$insert = "INSERT INTO Admin_Log (Admin_Log_ID, Admin_Log_In) VALUES ('$Admin_ID', '$date')";
		/* execute query */
		$insertdb = mysqli_query($con, $insert);

		header("Location: admin_console.php");

	} else {
		header("Location:".$_SERVER['HTTP_REFERER']); 
	}

	?>
</body>
</html>