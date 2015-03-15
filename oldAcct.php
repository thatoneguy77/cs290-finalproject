<?php
session_start();
include 'storedInfoF.php';
$username = $_POST["username"];
$password = $_POST["password"];
$_SESSION["username"] = $username;
$out_username = NULL;
$out_password = NULL;
$userHolder = NULL;
$passwordHolder = NULL;
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kernsbi-db", $myPassword, "kernsbi-db");
	
	if(!($stmt = $mysqli->prepare("SELECT username, password FROM login WHERE username=?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	$stmt->bind_param('s', $username);
	if(!$stmt->execute()) {
		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if(!$stmt->bind_result( $out_username, $out_password)) {
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$i = 0;

	while ($stmt->fetch()) {
		$userHolder = $out_username;
		$passwordHolder = $out_password;
	}
	$stmt->close();
	if($userHolder === $username && $passwordHolder === $password){
		echo "all good";
	}
	else{
		echo "not good";
	}
?>