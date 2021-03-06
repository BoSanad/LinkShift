<?php

//script to get the next token and save the (next token, long url)
//then return the short url to the user
//Saleh Alsanad, @bo9lo7
//saleh [AT] angelic [DOT] com

//given: url => long url

?>

<html>
<head>
<title>Linkshift</title>
</head>
<body style="text-align: center;">
<h1>Short Link!</h1>

<?php
require 'functions.php';

//check if long url is not set then exit
if (!isset($_POST['url'])) die("url is not set");

//init sql connection
$conn = init_sql_conn();

//check if sql connection is not made
if (!$conn) die("cannot connect to sql server");

//escape long url string to prevent sqli
$longurl = mysql_real_escape_string($_POST['url']);

//add http:// before url if it does not exists, bug discovered by @fR00s
if (!preg_match('/^https?\:\/\//', $longurl)) $longurl = "http://".$longurl; 

//check url validity
//bug discovered by @almhayat let me change the check method to regex
if (!preg_match('/^https?\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]+(\/.*)*$/', $longurl)) die('invalid url');

//check for url's existence
$t = get_url_token($longurl);

//check if the token exists
if ($t != FALSE) {
	//token exists, no need to save two tokens for one url
	echo form_short_url($t);
	exit;
}

//get the next token and increment the old one
$token = get_next_token_and_inc();

//check if the token is not valid (FALSE)
if (!$token) die("cannot generate short url");

//add the new (token, long url) into database
if (!add_long_url($token, $longurl)) die("cannot add long url");

//display short url to user
echo form_short_url($token);

?>

<div style="position: fixed; top: 90%; height: 100%; width: 100%;">
	<p>LinkShift open source project available at <a href="https://github.com/BoSanad/LinkShift">Github</a></p>	
</div>
</body>
</html>
