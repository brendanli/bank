<?php

$mysqli = new mysqli();

$server = "127.0.0.1";
//Replace these with your own username, password, database
$username = "username";
$password = "password";
$dbname = "db";

// Connect to database
$mysqli->connect($server, $username, $password, $dbname);

if ($mysqli->connect_error) {
	echo "Error connecting to database. " . "\n";
	echo "Errno: " . $mysqli->connect_errno . "\n";
	exit;
}

$acct = $_POST['acctnum'];
if(empty($acct)){
	echo("Please enter a valid account number.");
}
//echo("Creating account $acct" . "\n");

//First retrieve account to make sure it doesn't exist already

$query = "SELECT balance FROM BANK WHERE id = '" .  $acct . "'";
$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
if ($mysqli->errno) {
        printf("Error in query: %s <br />",$mysqli->error);
        exit();
}
$row = $result->fetch_row();
$value = $row[0];

if ($value != "") {
	echo "Account already exists.";
}
else {
	$sql = "INSERT INTO BANK VALUES ($acct,0)";
	if($mysqli->query($sql) === TRUE) {
		echo "Account created successfully.";
	}
	else {
		echo "Error creating account: " . $mysqli->error;
	}
}
$mysqli->close();
?>