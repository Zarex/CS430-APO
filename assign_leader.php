<?

function newPDO(){
	$dsn = "mysql:host=localhost;dbname=CS430";
	$user = "root";
	$pass = "root";
	return new PDO($dsn, $user, $pass);
}

function validateForm(){
	$m_id = $_POST['member'];
	$s_id = $_POST['shift'];

	echo $s_id;
	$db = newPDO();
   	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
   	
   	$sql = "INSERT INTO Leader (M_Id,S_Id) VALUES (:M_Id,:S_Id)";

	$stmt = $db->prepare($sql);

	$stmt->execute(array(':M_Id'=>$m_id,
						 ':S_Id'=>$s_id));

	print_r($stmt->errorInfo());
	$affected_rows = $stmt->rowCount();
	echo $affected_rows."<br/>";
}

function createEvent() {  

$db = newPDO();

$sql = "SELECT id,firstname,lastname 
		FROM Member
		WHERE Status_Id = (SELECT Status_Id FROM Status
			WHERE Name = 'Active')";
$stmt = $db->prepare($sql);
$stmt->execute();
$activeMembers = $stmt->fetchAll();
print_r($activeMembers);

$sql = "SELECT S.S_Id AS S_Id,S.E_Id,S.startTime AS start,S.endTime AS end,
		E.Name AS name,E.startDate AS dow
		FROM Shift S 
		JOIN Event E ON E.E_Id = S.E_Id";
$stmt = $db->prepare($sql);
$stmt->execute();
$shiftListing = $stmt->fetchAll();
print_r($shiftListing);

echo "
	<div class=\"content\">
	<form method=\"POST\"> 
<p> 
<b>The \"Assign Leaders\" Form</b><br/>

<label for=\"member\">Member</label>
<select name=\"member\">
";

foreach($activeMembers as $key=> $member){
	$id = $member['id'];
	$firstname = $member['firstname'];
	$lastname = $member['lastname'];

	echo "<option value={$id}>".$lastname." ".$firstname."</option>";
}
	
echo "
</select><br/>

<label for=\"shift\">Event</label>
<select name=\"shift\">
";

foreach($shiftListing as $key=> $shift){
	$S_Id = $shift['S_Id'];
	$start = $shift['start'];
	$end = $shift['end'];
	$name = $shift['name'];
	$dow = $shift['dow'];

	$dow = date('l',$dow);

	echo "<option value={$S_Id}>".$S_Id." ".$dow." ".$start." - ".$end." ".$name."</option>";
}
echo "
</select><br/>

<input type=\"hidden\" name=\"stage\" value=\"verify\" />
 	<p align=\"left\"><input type=\"submit\" value=\"Submit\" /></p>
</form> 
";

echo "<hr/>";
} 


if(isset($_POST['stage'])){
	validateForm();
}else{
createEvent();
}























