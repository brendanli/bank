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
$amount = $_POST['amount'];

if(empty($acct)){
	echo("Please enter a valid account number.");
}

if(empty($amount)){
	echo("Please enter a valid amount.");
}

$query = "SELECT balance FROM BANK WHERE id = '" .  $acct . "'";
$result = $mysqli->query($query,MYSQLI_STORE_RESULT);

if ($mysqli->errno) {
        printf("Error in query: %s <br />",$mysqli->error);
        exit();
}

// Extract last name from result returned
$row = $result->fetch_row();
$balance = $row[0];

if ($balance == "") {
	echo "Account does not exist.";
} /* 
else{
	echo "Balance for account $acct before withdrawal: $balance" . "\n";
}
*/
$newbalance = (int)$balance-(int)$amount;

if($newbalance < 0) {
	echo "Insufficient funds.";
}
else {
	$query = "UPDATE BANK SET balance = '" .  $newbalance . "' WHERE id = '" .  $acct . "'";

	if(mysqli_query($mysqli, $query)) {
		echo "Withdraw successful.";
	} else {
		echo "Transaction failed.";
	}
}

$mysqli->close();
?>