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
		<title>Search</title>
	</head>
	<body>
		<div class="navigation">
				<ul>
					<li><a href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/home.php">Home</a></li>
					<li><a style="margin-top:40px" href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/add.php">Add A Movie</a></li>
					<li><a href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/logout.php">Logout</a></li>
				</ul>
		</div>
		<div class="block"></div>
		<h1>Search IMDC, which once again, is not a knock off of IMDB.</h1>
		<div class="search">
				<form action="http://web.engr.oregonstate.edu/~kernsbi/finalProject/sortF.php">
				Search By Title<br><input type="text" name="title" id="title" required><br>
				<input type="submit" value="Search" style="width:218px; margin-left:auto; margin-right:auto; font-size:100%"><br>
				</form>
		</div>
	</body>
</html>
