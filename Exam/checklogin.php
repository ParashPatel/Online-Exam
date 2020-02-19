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

//Getting the entered username and password
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];

//Protect against mySQL injection
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

//mySQL query
$result=mysql_query("SELECT * FROM Members WHERE Username='$myusername' and Password='$mypassword' and Type='student'");
$result1=mysql_query("SELECT * FROM Members WHERE Username='$myusername' and Password='$mypassword' and Type='instructor'");

//Count the number of rows in the result
$count=mysql_num_rows($result);
$count1=mysql_num_rows($result1);

//If only one result, query matches database
if($count==1){
    echo "<script type='text/javascript'> 
	//alert('$submitted'); 
	document.location='https://web.njit.edu/~ssm72/CS490/Beta/student.html';</script>";   
}
elseif($count1==1){
	echo "<script type='text/javascript'> 
	//alert('$submitted'); 
	document.location='https://web.njit.edu/~ssm72/CS490/Beta/professor.html';</script>";
}
else {
	echo "<br />Login failed: Incorrect Username or Password!";
}

//Close the connection
mysql_close($link);

?>