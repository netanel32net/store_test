<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME', 'shopping');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function safe($text){
	$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$text = str_replace(",","",$text);
	$text = $con->real_escape_string(addslashes(strip_tags(htmlspecialchars($text))));
	return $text;
}
function password($text){
	$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$text = md5(sha1(md5(sha1($con->real_escape_string($text)).sha1($con->real_escape_string($text)))));
	return $text;
}

?>