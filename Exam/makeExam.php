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
$ID=$_POST['ID'];			

//mySQL query
$result=mysql_query("INSERT INTO Exam(Q_ID) VALUES ('$ID')");

mysql_close($link);

?>