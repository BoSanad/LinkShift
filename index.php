<?php
	//script to get long url and shorten it
	//then save it in database and show it to user
	//Saleh Alsanad, @bo9lo7
	//saleh [AT] angelic [DOT] com
?>

<html>
<head>
<title>linkshift</title>
</head>
<body style="text-align: center;">
<div style="top: 30%; left: 30%; position: fixed;">
<h1>LinkShift</h1>
<form method="post" action="short.php">
	<label for="url">URL:</label>
	<input type="text" name="url" size="60" /><br /><br />
	<input type="submit" value="Shorten" />
</form>
</div>
<div style="position: fixed; top: 90%; height: 100%; width: 100%;">
	<p>LinkShift open source project available at Github</p>	
</div>
</body>
</html>
