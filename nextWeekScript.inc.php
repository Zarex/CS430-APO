<?php

function newPDO(){
	$dsn = "mysql:host=localhost;dbname=CS430";
	$user = "root";
	$pass = "root";
	return new PDO($dsn, $user, $pass);
}

/*
 * Populate next week table
 * default eventStatus_Id = 1, 2= active, 3=canceled
 * Fri, push to occurrence table
 * Fri, push to occurrencqe table
 * clear next week table 
 */


   	$db = newPDO();
   	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
   	
   	$dateValue = date('N');
   	$dateValue -= 1;

   	$sql = "INSERT NextWeek (S_Id,startTime,endTime,Max)
   			SELECT Shift.S_Id,Event.startDate,Event.endDate,Shift.Max 
   			FROM Shift
   			JOIN Event ON Event.E_Id = Shift.E_Id
   			WHERE (Event.startDate > (NOW()+6-$dateValue) 
   				AND Event.startDate < (NOW()+13-$dateValue)) 
   				OR Event.Recurring = 'T'";

   $stmt = $db->prepare($sql);

   $stmt->execute();

   print_r($stmt->errorInfo());