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
		<title>Add</title>
		<script type="text/javascript">
		function ajaxStuff(){
			var request = new XMLHttpRequest();
			gTitle = "?title=";
    		gTitle += document.getElementById("mTitle").value;
    		if(document.getElementById("mTitle").value === ""){
    			var titl = document.getElementById("mTitle");
    			titl.value = "I need a title";
    			return;
    		}
    		gRank = "&rank=";
    		gRank += document.getElementById("rank").value;
    		if(document.getElementById("rank").value > 10||document.getElementById("rank").value < 0||document.getElementById("rank").value === ""){
    			alert("Must insert rank between 1 and 10")
    			return;
    		}
   			gDescription = "&description=";
  			gDescription += document.getElementById("mDescription").value;
   			gPrivate = "&private=";
            if(document.getElementById("mPrivate").checked){
    		    gPrivate += document.getElementById("mPrivate").value;
            }
            else{
                gPrivate += document.getElementById("mPrivate2").value;
            }
    		gLink = "&link=";
    		linkHolder = document.getElementById("link").value;
    		linkHolder2 = encodeURIComponent(linkHolder);
    		gLink += linkHolder2;
 
    		request.open('GET', 'http://web.engr.oregonstate.edu/~kernsbi/finalProject/newMovie.php' + gTitle + gRank + gDescription + gPrivate + gLink);
  			request.send();
			request.onreadystatechange = function() {
    			if(this.readyState === 4 && this.status === 200) {
    				var titl = document.getElementById("mTitle");
    				var titleHolder = document.getElementById("mTitle").value;
    				titl.value = null;
    				var ran = document.getElementById("rank");
    				ran.value = null;
    				var desc = document.getElementById("mDescription");
    				desc.value = null;
    				var success = document.getElementById("successful");
    				success.innerHTML = "Successfully added " + titleHolder;
    				success.style.backgroundColor = "#78AB46";
    			}
    			else{
    				var success = document.getElementById("successful");
    				success.innerHTML = "Could not add " + titleHolder + ". Please try again.";
    				success.style.backgroundColor = "#FF0000";
    			}
  			};
  		}
		</script>
	</head>
	<body>
		<div class="navigation">
				<ul>
					<li><a  href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/home.php">Home</a></li>
					<li><a style="margin-top:40px" href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/search.php">Search</a></li>
					<li><a href = "http://web.engr.oregonstate.edu/~kernsbi/finalProject/logout.php">Logout</a></li>
				</ul>
		</div>
		<div class="block"></div>
		<h1>Add to IMDC</h1>
		<div class="add">
			Movie Title <input type="text" id="mTitle" name="mTitle" style="margin-left:151px; margin-bottom:5px" required><br>
			Score(1-10) <input type="number" id="rank" name="rank" min="1" max="10" style="margin-left:149px; margin-bottom:5px" required><br>
			Description<textarea id="mDescription" name="mDescription" style="margin-left:160px; width:326px; margin-bottom:5px"></textarea><br>
			YouTube Trailer Link <input type="url" id="link" name="link" style="margin-left:24px; margin-bottom:5px"><br>
			Private? <input type="radio" id="mPrivate" name="mPrivate" checked="checked" value="1">Yes
			<input type="radio" id="mPrivate2" name="mPrivate" value="0">No
			<button onclick="ajaxStuff()" style="width:218px; margin-left:54px; font-size:100%">Add</button><br>
		</div>
		<p id="successful" style="margin-left:auto; margin-right:auto; text-align:center"></p>
	</body>
</html>