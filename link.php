<?php
//script to retreive the long url from database
//given that $_GET['l'] is short url token
//Saleh Alsanad, @bo9lo7
//saleh [AT] angelic [DOT] com

require 'functions.php';

if (!isset($_GET['l'])) die("token does not exists");

//init sql connection
$conn = init_sql_conn();

//check if sql connection is valid
if (!$conn) die("cannot connect to database");

//escape long url string to prevent sqli
$token = mysql_real_escape_string($_GET['l']);

//regex check the token
if (!preg_match('/^[a-zA-Z0-9]+$/', $token)) die("invalid token");

//get the long url and redirect user to it
$rs = mysql_query("SELECT longurl FROM links WHERE BINARY token = '". $token ."'");

//check if we got the long url
if (!$rs) die("error retreiving long url");

//check the number of rows in result set if its 0
if (mysql_num_rows($rs) == 0) {
	header("Location: ".BASE_URL."/notfound.php");
	exit;
}

//get the long url from the result set
$row = mysql_fetch_assoc($rs);

//check if we got the row correctly
if (!$row) die("error retreiving the long url");

//redirect the user to the long url
header("Location: ".$row['longurl']);

?>
