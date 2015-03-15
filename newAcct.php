<?php
session_start();
include 'storedInfoF.php';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kernsbi-db", $myPassword, "kernsbi-db");
if (!$mysqli || $mysqli->connect_errno) {
	echo "Failed to connect to database: (". $mysqli->connect_errno. ") ". $mysqli->connect_error;
}

$username = $_POST["username"];
$password = $_POST["password"];

if(!($stmt = $mysqli->prepare("INSERT INTO login(username, password) VALUES (?, ?)"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if(!$stmt->bind_param('ss', $username, $password)) {
	echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

if (!$stmt->execute()) {
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
$stmt->close();
?>