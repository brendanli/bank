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
$query = "SELECT balance FROM BANK WHERE id = '" .  $acct . "'";
$result = $mysqli->query($query,MYSQLI_STORE_RESULT);

if ($mysqli->errno) {
        printf("Error in query: %s <br />",$mysqli->error);
        exit();
}

$row = $result->fetch_row();
$value = $row[0];

if ($value == "") {
	echo "Account does not exist.";
} else{
	echo "Balance for account $acct: $value";
}

$mysqli->close();
?>