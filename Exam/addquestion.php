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
$question=$_POST['question'];
$testCase1=$_POST['testCase1'];
$testCase2=$_POST['testCase2'];
$testCase3=$_POST['testCase3'];
$diff=$_POST['diff'];

//Protect against mySQL injection
$question = stripslashes($question);
$testCase1 = stripslashes($testCase1);
$testCase2 = stripslashes($testCase2);
$testCase3 = stripslashes($testCase3);
$diff = stripslashes($diff);

$question = mysql_real_escape_string($question);
$testCase1 = mysql_real_escape_string($testCase1);
$testCase2 = mysql_real_escape_string($testCase2);
$testCase3 = mysql_real_escape_string($testCase3);
$diff = mysql_real_escape_string($diff);			

//mySQL query
$result=mysql_query("INSERT INTO Questions(Question, TC1, TC2, TC3, Difficulty) VALUES ('$question', '$testCase1', '$testCase2', '$testCase3', '$diff')");

mysql_close($link);

?>