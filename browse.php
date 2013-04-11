<?
require_once("utility_functions.inc.php");

$sql = "SELECT E.E_Id,E.Name AS name,E.startDate,E.endDate,E.Description,EventType.Name,E.Location,
		E.publicNotes,E.privateNotes,O.startTime AS startTime,O.endTime,O.Max
		FROM Occurrence AS O, Event AS E, EventType
		WHERE O.E_Id=E.E_Id AND EventType.T_Id=E.Type
		AND startTime >= NOW()
		GROUP BY O.startTime";

$db = newPDO();
$stmt = $db->prepare($sql);
$stmt->execute();

$events = $stmt->fetchAll();
	echo "<br/>";
	foreach ($events as $key => $e) {
		$name = $e['name'];
		$description = $e['Description'];
		$date = date('D g:i:s A',$e['startTime']);
		$startTimeFriendly = date('g:i:s A',$e['startTime']);
		$endTimeFriendly = date('g:i:s A',$e['endTime']);
		$location = $e['Location'];
		//$current
		$max = $e['Max'];
		$publicNotes = $e['publicNotes'];
		//$projectLeaderEmail = 
		//$projectLeaderPhone = 
		
		echo"
		<b>Name:</b> $name <br/>
		<b>Description:</b> $description
		<br/><strong>Date: </strong>{$date}

		<br/><strong>Time: </strong>{$startTimeFriendly}&nbsp;
				- {$endTimeFriendly}&nbsp;
				<br/><strong>Location: </strong>{$location}&nbsp;
				<br/><strong>Current: </strong>{$current}&nbsp;
				<br/><strong>Max: </strong>{$max}<br/>
				<strong>Notes: </strong>{$publicNotes}<br/>
				<strong>Project Leader: </strong>{$ProjectLeader}<br/>
				&nbsp;&nbsp;&nbsp;<strong>Email: </strong>{$projectLeaderEmail}<br/>
				&nbsp;&nbsp;&nbsp;<strong>Phone: </strong>{$projectLeaderPhone}<br/><p>
		<font color=\"blue\">Sign Up(not yet functional)</font></a>
		<hr/>
		<p>
		";
	}
