<?

function newPDO(){
	$dsn = "mysql:host=localhost;dbname=CS430";
	$user = "root";
	$pass = "root";
	return new PDO($dsn, $user, $pass);
}

function validateForm(){


// retrieve all post values
$eventName = $_POST['eventName'];
$eventDescription = $_POST['eventDescription'];
$eventDate = $_POST['eventDate'];
$type = $_POST['type'];
$type = 1;
$fundraising = $_POST['fundraising'];
$eventLocation = $_POST['eventLocation'];
$publicNotes = $_POST['publicNotes'];
$privateNotes = $_POST['privateNotes'];
$recurring = $_POST['recurring'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
echo "<br/>.".$startTime.".<br/>.".$endTime.".<br/>";
$max = $_POST['max'];
$projectLeader = $_POST['projectLeader'];

$startDate = $eventDate." ".$startTime.":00";
echo $startDate;
$endDate = $eventDate." ".$endTime.":00";
echo "<br/>";

// check to see if required items have values
if($eventName == NULL || $eventDescription == NULL || $eventDate == NULL || $eventLocation == NULL || $max == NULL)
	{
	  echo '<div class="entry"><strong>All of the required fields were not filled out.  Please try again.</strong></div>';
	 // print_form();
	}

// if the event is recurring, additional information is required
if($recurring != NULL && ($startTime == NULL || $endTime == NULL)){
	echo '<div class="entry"><strong>All of the required fields were not filled out.  Please try again.</strong></div>';
	// print_form();
}
// next steps are to range check some of the values and then insert them into the appropriate tables


   	$db = newPDO();
   	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
   	
   	$sql = "INSERT INTO Event (Name,startDate,endDate,Description,Type,Location,publicNotes,privateNotes,Recurring,Fundraising)
   			VALUES (:eventName,:startDate,:endDate,:eventDescription,:type,:eventLocation,:publicNotes,:privateNotes,:Recurring,:Fundraising)";

	$stmt = $db->prepare($sql);

	$stmt->execute(array(':eventName'=>$eventName,
						 ':startDate'=>$startDate,
						 ':endDate'=>$endDate,
						 ':eventDescription'=>$eventDescription,
						 ':type'=>$type,
						 ':eventLocation'=>$eventLocation,
						 ':publicNotes'=>$publicNotes,
						 ':privateNotes'=>$privateNotes,
						 ':Recurring'=>$recurring,
						 ':Fundraising'=>$fundraising));

	print_r($stmt->errorInfo());
	$affected_rows = $stmt->rowCount();
	echo $affected_rows."<br/>";
	
	$E_Id_LastInsert = $db->lastInsertId();
	echo $E_Id_LastInsert;

	$sql = "INSERT INTO Shift (E_Id,startTime,endTime,max) 
			VALUES (:E_Id,:startTime,:endTime,:max)";

	$stmt = $db->prepare($sql);
	echo "<br/>".$max."<br/>";

	$stmt->bindParam(":E_Id",$E_Id_LastInsert,PDO::PARAM_INT);
	$stmt->bindParam(":startTime",$startTime,PDO::PARAM_STR);
	$stmt->bindParam(":endTime",$endTime,PDO::PARAM_STR);
	$stmt->bindParam(":max",$max,PDO::PARAM_INT);
	$stmt->execute();
	/*
	$stmt->execute(array(':E_Id'=>$E_Id_LastInsert,
						 ':startTime'=>$startTime,
						 ':endTime'=>$endTime,
						 ':max'=>$max));
	*/
	print_r($stmt->errorInfo());
}

function createEvent() {   
echo <<<END
	<div class="content">
	<form method="POST"> 
<p> 
<b>The "Create Event" Form</b><br/> 
<label for="eventName">Event Name</label> 
<input type="text" name="eventName" value="Sample Event Name"/><br/>

<label for="eventDescription">Event Description</label><br/>
<textarea rows="3" cols="20" name="eventDescription">Event Description goes here</textarea><br/>

<label for="eventDate">Event Date</label>
<input type="date" name="eventDate"/><br/>

<label for="eventStartTime">Start Time: </label>
<input type="time" name="startTime"/><br/>

<label for="eventEndTime">End Time: </label>
<input type="time" name="endTime"/><br/>

<label for="type">Event Type</label>
<select name="type">
	<option value="" selected>Community</option>
	<option value="">Chapter</option>
	<option value="">Campus</option>
	<option value="">Country</option>
	<option value="">Broho</option>
</select><br/>

<label for="fundraising">Fundraising?</label>
<input type="radio" name="fundraising" value="T">yes
<input type="radio" name="fundraising" value="F" checked>no<br/>

<label for="Location">Location</label>
<input type="text" name="eventLocation" value="SUB"/><br/>

<label for="Notes">Public Notes</label><br/>
<textarea rows="3" cols="20" name="publicNotes">public note test</textarea><br/>

<label for="Notes">Private Notes</label><br/>
<textarea rows="3" cols="20" name="privateNotes">private note test</textarea><br/>

<label for="Recurring">Recurring?</label><br/>
<input type="radio" name="recurring" value="T">yes
<input type="radio" name="recurring" value="F" checked>no<br/>

<label for="maxEnrollment">Max Enrollment</label>
<input type="number" name="max" min="1" max="150" value="10"/><br/>

<input type="hidden" name="stage" value="verify" />
 	<p align="left"><input type="submit" value="Submit" /></p>
</form> 
END;

echo "<hr/>";
} 


if(isset($_POST['stage'])){
	validateForm();
}else{
createEvent();
}























