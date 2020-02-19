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

$check = mysql_query("SELECT * FROM Result");
$count=mysql_num_rows($check);  
 
if($count>=2){  
	$sth = mysql_query("SELECT * FROM Scores;");
	$rows = array();

	while($r = mysql_fetch_assoc($sth)) {
    	$rows[] = $r;
		$question = $r["question"];
		$answer = $r["answer"];
		$fnctn = $r["fnctn"];
		$arguments = $r["arguments"];
		$prnt_rtrn = $r["prnt_rtrn"];
		$compile = $r["compile"];
		$testcase = $r["testcase"];
		$totalscore = $r["totalscore"];
      	$pointforReq = $r["pointforReq"];
      	
		$examScores = array(
      		'question' => $question,
      		'answer' => $answer,
      		'fnctn' => $fnctn,
      		'arguments' => $arguments,
      		'prnt_rtrn' => $prnt_rtrn,
      		'compile' => $compile,
      		'testcase' => $testcase,
      		'totalscore' => $totalscore,
      		'pointforReq' => $pointforReq,
    	);
        
    	$examScores = json_encode($examScores);
        
    	$ch = curl_init();
    	$url = "https://web.njit.edu/~rd278/CS490/Beta/getScoreFromBack.php";
        
    	curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $examScores);
        
    	$output = curl_exec($ch);
        
    	if($output === FALSE){ 
    	    echo "cURL Error: " . curl_error($ch);
    	} 
}     
}

curl_close($ch);
  
mysql_close($link);

?>