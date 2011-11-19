<?php
//functions library
//Saleh Alsanad, @bo9lo7
//saleh [AT] angelic [DOT] com

require 'config.inc';

//function to setup mysql connection
//returns connection handle
function init_sql_conn()
{
	//start mysql connection
	$conn = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);

	//check the connection state
	if (!$conn) return FALSE;

	//select the database
	if (!mysql_select_db(MYSQL_DB)) return FALSE;

	//return the connection handle
	return $conn;
}

//function to increment the token
//returns the incremented token
function inc($t)
{
	if ($t == FALSE) return '1';
	$chars = array(0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => 'a', 11 => 'b', 12 => 'c', 13 => 'd', 14 => 'e', 15 => 'f', 16 => 'g', 17 => 'h', 18 => 'i', 19 => 'j', 20 => 'k', 21 => 'l', 22 => 'm', 23 => 'n', 24 => 'o', 25 => 'p', 26 => 'q', 27 => 'r', 28 => 's', 29 => 't', 30 => 'u', 31 => 'v', 32 => 'w', 33 => 'x', 34 => 'y', 35 => 'z', 36 => 'A', 37 => 'B', 38 => 'C', 39 => 'D', 40 => 'E', 41 => 'F', 42 => 'G', 43 => 'H', 44 => 'I', 45 => 'J', 46 => 'K', 47 => 'L', 48 => 'M', 49 => 'N', 50 => 'O', 51 => 'P', 52 => 'Q', 53 => 'R', 54 => 'S', 55 => 'T', 56 => 'U', 57 => 'V', 58 => 'W', 59 => 'X', 60 => 'Y', 61 => 'Z');
	$l = substr($t, -1);
	$p = substr($t, 0, strlen($t)-1);
	$k = array_search($l, $chars);
	$k++;
	if ($k > 61) return inc($p).'0';
	return $p.$chars[$k];
}

//function to always get next token to be used
//in the shortened url
//returns the token available for use OR FALSE
function get_next_token_and_inc()
{
	//select the token value from nexttoken column in token table
	$rs = mysql_query("SELECT nexttoken FROM token WHERE id = 1");

	//check if the returned value is FALSE
	if (!$rs) return FALSE;

	//fetch the resultset and get the nexttoken column only
	$row = mysql_fetch_assoc($rs);	

	//check if the row is valid (!FALSE)
	if (!$row) return FALSE;

	//save the token retreived
	$token = $row['nexttoken'];

	//increment (by our algorithm) the token
	$itoken = inc($token);

	//update the nexttoken column in token table in database
	if (!mysql_query("UPDATE token SET nexttoken = '". $itoken ."' WHERE id = 1")) return FALSE;

	//return the token
	return $token;
}

//function to add the (token, url) given to db
//returns boolean depending on add operation result
function add_long_url($token, $url)
{
	//insert the (token, url) to database
	return mysql_query("INSERT INTO links (token, longurl) VALUES ('".$token."', '".$url."')");
} 

//function to format the short url from the token
function form_short_url($token)
{
	//format: BASE_URL/token
	return BASE_URL."/".$token;
}

//function to get the token given the long url
function get_url_token($url)
{
	//select the token from links table
	$rs = mysql_query("SELECT token FROM links WHERE longurl = '".$url."'");

	//check result set
	if (!$rs) return FALSE;

	//get the token from the result set
	$row = mysql_fetch_assoc($rs);

	//check if we got the row correctly
	if (!$row) return FALSE;

	//return the token
	return $row['token'];
}

?>
