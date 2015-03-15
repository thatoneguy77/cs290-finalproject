<?php
include 'storedInfoF.php';
session_start();
if(is_null($_SESSION["username"])){
	header('Location: http://web.engr.oregonstate.edu/~kernsbi/finalProject/login.html');
}
echo '<!DOCTYPE html>
<html lang="en"
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<meta charset="utf-8" />
<title>Search</title>
</head>
<body>';
$out_title = NULL;
$out_rank = NULL;
$out_description = NULL;
$out_link = NULL;
$out_name = NULL;
$out_private = NULL;
$uName = $_SESSION["username"];
$mTitle = htmlspecialchars($_GET["title"]);

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kernsbi-db", $myPassword, "kernsbi-db");
	
	if(!($stmt = $mysqli->prepare("SELECT title, rank, mDescription, private, link, name FROM movies WHERE title=?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	$stmt->bind_param('s', $mTitle);
	if(!$stmt->execute()) {
		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if(!$stmt->bind_result( $out_title, $out_rank, $out_description, $out_private, $out_link, $out_name)) {
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$i = 0;
	//$titleHolder = array();
	$nameHolder = array();
	$rankHolder = array();
	$descriptionTableHolder = array();
	$holder = array();
	$rHolder = array();

	while ($stmt->fetch()) {
		if($out_private == 0){
			$titleHolder = $out_title;
			$rankHolder[$i] = $out_rank;
			$descriptionTableHolder[$i] = $out_description;
			if(!empty($out_link)){
				$linkHolder = $out_link;
			}
			$i++;
		}
		else if($out_private !== 0 && $uName === $out_name){
			$titleHolder = $out_title;
			$rankHolder[$i] = $out_rank;
			$descriptionTableHolder[$i] = $out_description;
			if(!empty($out_link)){
				$linkHolder = $out_link;
			}
			$i++;
		}
	}
	$stmt->close();
	$rHolder = array_sum($rankHolder) / count($rankHolder); 

	$holder = explode('=', $linkHolder);
	echo '<div class="navigation">
				<ul style="margin-left:-35%">
					<li><a href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/home.php">Home</a></li>
					<li><a style="margin-top:40px" href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/add.php">Add</a></li>
					<li><a href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/logout.php">Logout</a></li>
				</ul>
		</div>';
	echo '<div class="block"></div>';
	echo '<div class="search">';
	echo '<h1 style="font-size:300%; margin-top:18%;">IMDB Search Result</h1>';
	if(empty($titleHolder) != TRUE){
		echo '<h1 style="font-size:300%; margin-top:18%;">' . $titleHolder . '<br>Score: ' . $rHolder . '</h1>';
		echo '<h1 style="font-size:200%; margin-top:18%;">Description</h1>';
		for($r = 0; $r < $i; $r++){
			echo '<p style="font-size:60%; margin-top:4%; margin-left:7%; margin-bottom:5%">' . $descriptionTableHolder[$r];
		}
		for($r = 0; $r < $i; $r++){
			if(empty($linkHolder)==FALSE){
				$r++;
				echo '<h1 style="font-size:200%; margin-top:18%;">Trailer</h1>';
				echo '<iframe style="margin-top:2%; margin-bottom:11%" width="560" height="315" src="https://www.youtube.com/embed/'. $holder[$r] . '" frameborder="0" allowfullscreen></iframe>';
			}
		}
		echo '</div>';
	}
	else{
		echo '<h1 style="font-size:300%; margin-top:18%;">Nothing Found</h1>';
	}
	echo '</body>';
	echo '</html>';
?>