<?php
	//script to get long url and shorten it
	//then save it in database and show it to user
	//Saleh Alsanad, @bo9lo7
	//saleh [AT] angelic [DOT] com

require 'config.inc';

?>

<html>
<head>
<title>linkshift</title>
</head>
<body style="text-align: center;">
<div>
<p>Drag this bookmarklet to your bookmarks to shorten links on the go <a style="background: none repeat scroll 0 0 #DDDDDD; color: darkgreen; text-decoration: none; border: 1px outset #DDDDDD; padding: 1px; vertical-align: 1px;" href="javascript:void(location.href='<?php echo API_BASE_URL."/short.php?url='+encodeURIComponent(location.href))" ?>">LinkShift</a></p>
</div>
<div style="top: 30%; left: 30%; position: fixed;">
<h1>LinkShift</h1>
<form method="post" action="short.php">
	<label for="url">URL:</label>
	<input type="text" name="url" size="60" /><br /><br />
	<input type="submit" value="Shorten" />
</form>
</div>
<div style="position: fixed; top: 90%; height: 100%; width: 100%;">
	<p>LinkShift open source project available at <a href="https://github.com/BoSanad/LinkShift">Github</a></p>	
</div>
</body>
</html>
