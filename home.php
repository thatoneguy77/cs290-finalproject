<?php
session_start();
if(is_null($_SESSION["username"])){
	header('Location: http://web.engr.oregonstate.edu/~kernsbi/finalProject/login.html');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta charset="UTF-8">
		<title>Home</title>
	</head>
	
	<body>
		<?php
		$name = $_SESSION["username"];
		echo '<h1>Welcome Home, ' . $name . '</h1>';
		?>
		<div class="navigation">
				<ul>
					<li><a  href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/add.php">Add A Movie</a></li>
					<li><a style="margin-top:40px" href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/search.php">Search</a></li>
					<li><a href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/logout.php">Logout</a></li>
				</ul>
		</div>
		<div class="lotsOfMovies">
			<h1 style="margin-top:10%">Movies on IMDC</h1>
			<?php
				//session_start();
				include 'storedInfoF.php';
				$out_title = NULL;
				$out_rank = NULL;
				$out_description = NULL;
				$out_link = NULL;
				$private = 0;
				$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kernsbi-db", $myPassword, "kernsbi-db");
	
				if(!($stmt = $mysqli->prepare("SELECT title, rank, mDescription, link FROM movies WHERE private=?"))) {
					echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				$stmt->bind_param('i', $private);
				if(!$stmt->execute()) {
					echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				if(!$stmt->bind_result( $out_title, $out_rank, $out_description, $out_link)) {
					echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				$i = 0;
				$titleHolder = array();
				$rankHolder = array();

				while ($stmt->fetch()) {
					if(in_array($out_title, $titleHolder)){
						$titleHolder[$i] = NULL;
					}
					else{
						$titleHolder[$i] = $out_title;
					}
					$i++;
				}
				$stmt->close();
				for($q = 0; $q < $i; $q++){
					echo '<div class="block"></div>';
					if($titleHolder[$q] !== NULL){
						echo '<h1 style="margin-top:4%"><a href="http://web.engr.oregonstate.edu/~kernsbi/finalProject/sortF.php?title=' . $titleHolder[$q] . '">' . $titleHolder[$q] . '</a></h1>';
					}
				}
			?>
		</div>
		<div class="lotsOfMovies">
			<h1 style="margin-top:12%">Your Collection</h1>
			<?php
				//session_start();
				include 'storedInfoF.php';
				$out_title = NULL;
				$out_rank = NULL;
				$out_description = NULL;
				$out_link = NULL;

				$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kernsbi-db", $myPassword, "kernsbi-db");
	
				if(!($stmt = $mysqli->prepare("SELECT title, rank, mDescription, link FROM movies WHERE name=?"))) {
					echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				$stmt->bind_param('s', $name);
				if(!$stmt->execute()) {
					echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				if(!$stmt->bind_result( $out_title, $out_rank, $out_description, $out_link)) {
					echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				$i = 0;
				$titleHolder = array();
				$rankHolder = array();

				while ($stmt->fetch()) {
					if(in_array($out_title, $titleHolder)){
						$titleHolder[$i] = NULL;
					}
					else{
						$titleHolder[$i] = $out_title;
					}
					$i++;
				}
				$stmt->close();
				for($q = 0; $q < $i; $q++){
					echo '<div class="block"></div>';
					if($titleHolder[$q] !== NULL){
						echo '<h1 style="margin-top:4%"><a href="http://web.engr.oregonstate.edu/~kernsbi/finalProject/sortF.php?title=' . $titleHolder[$q] . '">' . $titleHolder[$q] . '</a></h1>';
					}
				}
				echo '<p style="margin-bottom:200px"></p>';
			?>
		</div>
	</body>
</html>