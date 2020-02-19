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
  
$sth = mysql_query("SELECT * FROM Questions");
$rows = array();

while($r = mysql_fetch_assoc($sth)) {
    $rows[] = $r;
	$id = $r['ID'];
    $Question = $r['Question'];
	$diff = $r['Difficulty'];
    $TC1 = $r['TC1'];
    $TC2 = $r['TC2'];
    $TC3 = $r['TC3'];  
      
    $question_info = array(
    	'id' => $id,
      	'Question' => $Question,
      	'diff' => $diff,
      	'TC1' => $TC1,
      	'TC2' => $TC2,
      	'TC3' => $TC3,
	);
        
	$questionInfo = json_encode($question_info);
        
	$ch = curl_init(); 
    $url = "https://web.njit.edu/~rd278/CS490/Beta/sendQuestion.php";
    
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $questionInfo);
        
    $output = curl_exec($ch);
        
    if($output === FALSE){ 
	   	echo "cURL Error: " . curl_error($ch); 
    }      
}
  
curl_close($ch);
  
mysql_close($link);

?>	