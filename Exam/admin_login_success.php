<?php
$link = mysql_connect('sql2.njit.edu', 'mr373', 'Vl8XhH4w6');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

echo "Connected to Mysql<br/><hr/>";

$db_selected = mysql_select_db('mr373', $link);
if (!$db_selected) {
    die ('Can\'t use mr373 : ' . mysql_error());
}
echo"Connected to mr373 Database<br/><hr>";
echo"Logged in as Administrator<br/><hr>";
?>

<html>
<head>
<script>
function goLastMonth(month, year){
if(month == 1) {
--year;
month = 13;
}
--month
var monthstring= ""+month+"";
var monthlength = monthstring.length;
if(monthlength <=1){
monthstring = "0" + monthstring;
}
document.location.href ="<?php $_SERVER['PHP_SELF'];?>?month="+monthstring+"&year="+year;
}
function goNextMonth(month, year){
if(month == 12) {
++year;
month = 0;
}
++month
var monthstring= ""+month+"";
var monthlength = monthstring.length;
if(monthlength <=1){
monthstring = "0" + monthstring;
}
document.location.href ="<?php $_SERVER['PHP_SELF'];?>?month="+monthstring+"&year="+year;
}
</script>
<style>
.today{
background-color: #00ff00;
}
.event{
background-color: #FF8080;
}
</style>
</head>
<body>
<?php
if (isset($_GET['day'])){
$day = $_GET['day'];
} else {
$day = date("j");
}
if(isset($_GET['month'])){
$month = $_GET['month'];
} else {
$month = date("n");
}
if(isset($_GET['year'])){
$year = $_GET['year'];
}else{
$year = date("Y");
}
$currentTimeStamp = strtotime( "$day-$month-$year");
$monthName = date("F", $currentTimeStamp);
$numDays = date("t", $currentTimeStamp);
$counter = 0;
?>
<?php
if(isset($_GET['add'])){
$title =$_POST['txttitle'];
$detail =$_POST['txtdetail'];
$eventdate = $month."/".$day."/".$year;
$sqlinsert = "INSERT into eventcalendar(Title,Detail,eventDate,dateAdded) values ('".$title."','".$detail."','".$eventdate."',now())";
$resultinginsert = mysql_query($sqlinsert);
if($resultinginsert ){
echo "Event was successfully Added...";
}else{
echo "Event Failed to be Added....";
}
}
?>

<table border='1'>
<tr>
<td><input style='width:50px;' type='button' value='<'name='previousbutton' onclick ="goLastMonth(<?php echo $month.",".$year?>)"></td>
<td colspan='5'><?php echo $monthName.", ".$year; ?></td>
<td><input style='width:50px;' type='button' value='>'name='nextbutton' onclick ="goNextMonth(<?php echo $month.",".$year?>)"></td>
</tr>
<tr>
<td width='50px'>Sun</td>
<td width='50px'>Mon</td>
<td width='50px'>Tue</td>
<td width='50px'>Wed</td>
<td width='50px'>Thu</td>
<td width='50px'>Fri</td>
<td width='50px'>Sat</td>
</tr>
<?php
echo "<tr>";
for($i = 1; $i < $numDays+1; $i++, $counter++){
$timeStamp = strtotime("$year-$month-$i");
if($i == 1) {
$firstDay = date("w", $timeStamp);
for($j = 0; $j < $firstDay; $j++, $counter++) {
echo "<td>&nbsp;</td>";
}
}
if($counter % 7 == 0) {
echo"</tr><tr>";
}
$monthstring = $month;
$monthlength = strlen($monthstring);
$daystring = $i;
$daylength = strlen($daystring);
if($monthlength <= 1){
$monthstring = "0".$monthstring;
}
if($daylength <=1){
$daystring = "0".$daystring;
}
$todaysDate = date("m/d/Y");
$dateToCompare = $monthstring. '/' . $daystring. '/' . $year;
echo "<td align='center' ";
if ($todaysDate == $dateToCompare){
echo "class ='today'";
} else{
$sqlCount = "select * from eventcalendar where eventDate='".$dateToCompare."'";
$noOfEvent = mysql_num_rows(mysql_query($sqlCount));
if($noOfEvent >= 1){
echo "class='event'";
}
}
echo "><a href='".$_SERVER['PHP_SELF']."?month=".$monthstring."&day=".$daystring."&year=".$year."&v=true'>".$i."</a></td>";
}
echo "</tr>";
?>
</table>

<?php
if(isset($_GET['v'])) {
echo "<hr>";
echo "<a href='".$_SERVER['PHP_SELF']."?month=".$month."&day=".$day."&year=".$year."&v=true&f=true'>Add Event</a>";
if(isset($_GET['f'])) {
include("add_eventcalendar.php");

}
$sqlEvent = "select * FROM eventcalendar where eventDate='".$month."/".$day."/".$year."'";
$resultEvents = mysql_query($sqlEvent);
echo "<hr>";


while ($events = mysql_fetch_array($resultEvents)){
echo "Title: ".$events['Title']."<br>";
echo "Detail: ".$events['Detail']."<br>";

}
}

?>


<form action='' method='POST'>
<?php

$sqlEvent = "select * FROM eventcalendar where eventDate='".$month."/".$day."/".$year."'";

$resultid = mysql_query($sqlEvent);
while ($row = mysql_fetch_object($resultid)) {
    //echo $row->ID;
	$eventid = $row->ID;
	$eventtitle = $row->Title;
	//echo $eventid;
	echo  "  To delete event <b>$eventtitle</b> Click The Button to the Right <input type='submit' name='delete' value='".$eventid."' /><br/>";
	if(isset($_POST['delete'])){

	$eventid = $_POST['delete'];
	$delete_query = mysql_query("DELETE FROM eventcalendar WHERE ID = $eventid ") or die(mysql_error());

	if($delete_query) {
					echo 'event with id '.$eventid.' is removed from your table, to refresh your page, click'. '<a href='.$_SERVER["PHP_SELF"].' > here </a>';

					  }
		}
	}
//mysql_free_result($resultid);


?>
</form>






<a href="https://web.njit.edu/~mr373/cs490/logout.php">Logout</a> 
</body>
</html>