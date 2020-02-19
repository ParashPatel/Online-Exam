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
if (isset($_POST["question"]))
	$question=$_POST['question'];
if (isset($_POST["answer"]))
	$answer=$_POST['answer'];
if (isset($_POST["fnctn"]))
	$fnctn = $_POST["fnctn"];
if (isset($_POST["arguments"]))
	$arguments = $_POST["arguments"];
if (isset($_POST["prnt_rtrn"]))
	$prnt_rtrn = $_POST["prnt_rtrn"];
if (isset($_POST["compile"]))
	$compile = $_POST["compile"];
if (isset($_POST["testcase"]))
	$testcase = $_POST["testcase"];
if (isset($_POST["totalscore"]))
	$totalscore = $_POST["totalscore"];		
if (isset($_POST["pointforReq"]))
	$pointforReq = $_POST["pointforReq"];	

//mySQL query
$result=mysql_query("INSERT INTO Scores(question, answer, fnctn, arguments, prnt_rtrn, compile, testcase, totalscore, pointforReq) VALUES ('$question', '$answer', '$fnctn', '$arguments', '$prnt_rtrn', '$compile', '$testcase', '$totalscore', '$pointforReq')");

mysql_close($link);

?>