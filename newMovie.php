<?php
session_start();
include 'storedInfoF.php';
$name = $_SESSION["username"];
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kernsbi-db", $myPassword, "kernsbi-db");
if (!$mysqli || $mysqli->connect_errno) {
	echo "Failed to connect to database: (". $mysqli->connect_errno. ") ". $mysqli->connect_error;
}

$mTitle = htmlspecialchars($_GET["title"]);
$rank = htmlspecialchars($_GET["rank"]);
$mDescription = htmlspecialchars($_GET["description"]);
$private = htmlspecialchars($_GET["private"]);
$link = htmlspecialchars($_GET["link"]);
$link = rawurldecode($link);

if(!($stmt = $mysqli->prepare("INSERT INTO movies(title, rank, mDescription, private, link, name) VALUES (?, ?, ?, ?, ?, ?)"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if(!$stmt->bind_param('ssssss', $mTitle, $rank, $mDescription, $private, $link, $name)) {
	echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

if (!$stmt->execute()) {
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
$stmt->close();
?>