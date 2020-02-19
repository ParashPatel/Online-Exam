<?php

//Connect to my database
$link = mysql_connect('sql2.njit.edu', 'pp385', 'm1VF84Get');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

//Select members table
$db_selected = mysql_select_db('pp385', $link);
if (!$db_selected) {
    die ('Can\'t use pp385 : ' . mysql_error());
}

//Getting the entered question information
if (isset($_POST["releaseScore"]))
	$releaseScore=$_POST['releaseScore'];			

//mySQL query
//$result=mysql_query("UPDATE Result SET releaseScore=$releaseScore");
$result=mysql_query("Insert INTO Result(releaseScore) VALUES ('$releaseScore')");
					
mysql_close($link);

?>