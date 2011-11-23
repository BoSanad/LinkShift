<?php

//script to expose url shorting functional as API
//Saleh Alsanad, @bo9lo7
//saleh [AT] angelic [DOT] com

require '../functions.php';

//check if long url is not set then exit
if (!isset($_GET['url'])) die("url is not set");

//init sql connection
$conn = init_sql_conn();

//check if sql connection is not made
if (!$conn) die("cannot connect to sql server");

//decode the long url then escape it to prevent sqli
$longurl = mysql_real_escape_string(urldecode($_GET['url']));

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
