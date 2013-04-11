<?php

require_once('utility_functions.inc.php');
$options = loadOptions();

session_start();

function process_form() {	

	$result = 'sucess';

	$id = $_SESSION['id'];
	$event = $_POST['event'];
	$month = $_POST['month']; 
    $day = $_POST['day'];
    $year = $_POST['year'];   
    $date = "$year-$month-$day";    
	$description = $_POST['description'];
	$hours = $_POST['hours'];
	$hours = round($hours, 2);
	$servicetype = $_POST['servicetype'];
	$fundraising = $_POST['fundraising'];
	$semester = $_POST['semester'];

	$description = htmlspecialchars($description, ENT_QUOTES);
	if ($month == NULL || $day == NULL || $event == NULL || $hours == NULL || $servicetype == NULL) {
		$result = "Your didn't fill out the form completely.<br/>";
	}
	else if ($description == 'Rush Week' || $description == 'KCOM' || $description == 'Lancaster' || $description == 'CSI Friday' || $description == 'Ray Miller' || $description == 'Pop-Tab Collection' ||$description == 'Twin Pines' ||$description == 'Humane Society' ||$description == 'Adair Co. Library' ||$description == 'Recycling Center' ||$description == 'Bought Hours' ||$description == 'Camp' ||$description == 'Bake sale' ||$description == 'Large Service Project' ||$description == 'Other Service Project' ||$description == 'Non-APO Hours' || $description == 'NMCAA' || $description == 'Multicultural Affairs Center' || $description == "MAC" || $description == 'Highway Cleanup' || $description == 'SAA Babysitting') {
		$result = "<div class='entry'>The description cannot be the same as the event. Please enter a valid description so that exec can verify that you did the service hours. <br/></div>";
	}
	else {
		
		$db = newPDO();

		$sql = "INSERT INTO recorded_hours (user_id,date,semester,description,hours,
							servicetype,fundraising,event)
				VALUES(:user_id,:thedate,:semester,:description,:hours,:servicetype,
						:fundraising,:event)";
		$stmt = $db->prepare($sql);

		$stmt->execute(array(':user_id'=>$id,
							 ':thedate'=>$date,
							 ':semester'=>$semester,
							 ':description'=>$description,
							 ':hours'=>$hours,
							 ':servicetype'=>$servicetype,
							 ':fundraising'=>$fundraising,
							 ':event'=>$event));

		print_r($stmt->errorInfo());


	}
return $result;
}




if(isset($_SESSION['id'])){
	print_r($_SESSION);
}else{
	header("Location: http://localhost/login.php");
	exit();
}

if(isset($_POST['action']) && ('add_hour' == $_POST['action'])){
	$err = process_form();
	echo $err;
}else{
	echo $_POST['action'];
	echo "nothing processed";
}
function print_form(){
	echo<<<END

	<div style="clear:both;"></div>


	<div id="service_bar">
	<table><tr><td rowspan='2' valign='top'>
	<div id="service_log">
	<h2>Log Hours</h2> 
	<form action="" method="POST"> 
	<p>
		<label for="month">Date</label> 
			<select name="month">
	END;
		$month_no = date('n');
	$month_name = date('M');
		echo "<option value=\"$month_no\">".$month_name."</option>";
	for($i=1;$i<=12;$i++){
		$date = date('M',mktime(0,0,0,$i,0,0));
		echo "<option value=\"$i\">".$date."</option>";
	}
	echo <<<END
			</select> 
			<select name="day"> 
	END;
		$day_of_month = date('j');
		echo "<option value=\"$day_of_month\">".$day_of_month."</option>";
	for($i=1;$i<=31;$i++){
		echo "<option value=\"$i\">".$i."</option>";
	}
	echo<<<END
			</select>,
			<select name="year">
	END;
	for($i=0;$i>=-1;$i--){
		$date = date('Y');
		$date += $i;
		echo "<option value=\"$date\">".$date."</option>";
	}
	echo<<<END
			</select> 
	</p> 
	<p>
		<label for="volunteer_time_event">Event</label> 
	  		<select id="volunteer_time_event" name="event">
	  			<option value="Bought Hours">Bought Hours</option> 
				<option value="Camp">Camp</option> 
				<option value="Bake Sale">Bake Sale</option> 
				<option value="Sections Service Project">Sections Service Project</option> 
				<option value="Other Service Project">Other Service Project</option> 
				<option value="Large Service Project">Large Service Project</option> 
				<option value="Non-APO Hours">Non-APO Hours</option> 
				<option value="Blood Drive">Blood Drive</option>
				<option value="Highway Cleanup">Highway Cleanup</option>
				<option value="Rush Week">Rush Week</option>
			</select> 
	</p> 
	<p>
		<label for="hours">Hours</label>
			<input name="hours" size="30" style="width: 30px;" type="text" /> 
	</p> 
	<p>
		<label for="servicetype">Service type</label> 
			<select name="servicetype">
				<option value="Community">Community</option> 
				<option value="Chapter">Chapter</option> 
				<option value="Country">Country</option> 
				<option value="Campus">Campus</option></select> 
	</p> 
	<p>
		<label for="fundraising">Fundraising</label>
			<input name="fundraising" type="checkbox" value="1" /> 
	</p> 
	<p>
		<label for="description">Description</label> 
	  		<input name="description" size="30" type="text" /> 
	</p> 
	<p>
		<label for="semester">Semester</label> 
	  		<select name="semester">
	END;
	/* very important that these values are option_id -1 on table_name Options */
	echo "<option value=\"".$options[2][option_value]."\">".$options[2][option_value]."</option>";
	echo "<option value=\"".$options[1][option_value]."\">".$options[1][option_value]."</option>";	
	echo<<<END

	  			</select>
	</p> 
	<p align="center">
			<input type='hidden' name='action' value='add_hour'/>
			<input type='submit' value='Log Hours' style='font-weight:bold;'/>

	</p> 
	</form> 
	</div>
	</td>

	<td>
	<div id="service_requirements">
	<h2>Service Policy</h2>

	Active: <b>25</b> hours of service.<br>
	<b>18</b> hours must be APO service hours.<br>
	<b>3</b> out of the 4 fields of service: Chapter, Campus, Community, Country.<br>
	<b>3</b> hours of fundraising.<br>
	Maximum of <b>5</b> bought hours<br>
	Associate: <b>12.5</b> hours of service <br>
	9 hours must be APO service hours
	</div>
	</td></tr>
	<tr><td>
	<div id="service_stats">
END;
}

function list_stats($hours_id, $semester) {
	// Total Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		$total_hours = round($i['sum_hours'], 2);
		echo "<span>Total Hours:</span> $total_hours<br/>";
	}
	
	// APO Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `event` != 'Non-APO Hours'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) {
		$apo_hours = round($i['sum_hours'], 2);
		echo "<span>APO Hours:</span> $apo_hours<br/>";
	}
	
	// Chapter Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Chapter'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Chapter Hours:</span> $i[sum_hours]<br/>";
	}
	
	// Campus Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Campus'  AND `semester` = '$semester' LIMIT 1";
	
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Campus Hours:</span> $i[sum_hours]<br/>";
	}
	
	// Community Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Community'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		$community_hours = round($i['sum_hours'], 2);
		echo "<span>Community Hours:</span> $community_hours<br/>";
	}
	
	// Country Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Country'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Country Hours:</span> $i[sum_hours]<br/>";
	}
		
	// Fundraising Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `fundraising` = '1'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Fundraising Hours:</span> $i[sum_hours]<br/>";
	}
	

	// Bought Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `event` = 'Bought Hours'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Bought Hours:</span> $i[sum_hours]<br/>";
	}
}




















