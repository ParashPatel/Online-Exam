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
  
$sth = mysql_query("SELECT * FROM Questions INNER JOIN Exam ON Questions.ID=Exam.Q_ID;");
$rows = array();

while($r = mysql_fetch_assoc($sth)) {
	$rows[] = $r;
    $ID = $r['ID'];
    $Question = $r['Question'];
    $Difficulty = $r['Difficulty'];
    $Q_ID = $r['Q_ID'];
        
    $examQuestions = array(
    	'ID' => $ID,
      	'Question' => $Question,
      	'Difficulty' => $Difficulty,
      	'Q_ID' => $Q_ID,
    );
        
	$examQuestions = json_encode($examQuestions);
        
	$ch = curl_init();
    $url = "https://web.njit.edu/~ssm72/CS490/Beta/makeExam/tempSelectedFromDB.php";
        
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $examQuestions);
        
    $output = curl_exec($ch); 
        
    if($output === FALSE){ 
    	echo "cURL Error: " . curl_error($ch); 
    }      
}

curl_close($ch);
  
mysql_close($link);

?>