<?php

require_once('utility_functions.inc.php');

function populateServiceNextWeek(){
   	$db = newPDO();
   	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
   	
   	$dateValue = date('N');
   	$dateValue -= 1;

   	$sql = "INSERT ServiceNextWeek (E_Id,S_Id,startTime,endTime,Max)
   			SELECT Event.E_Id,Shift.S_Id,Event.startDate,Event.endDate,Shift.Max
   			FROM Shift
   			JOIN Event ON Event.E_Id = Shift.E_Id
            JOIN EventType ON EventType.T_Id = Event.Type
   			WHERE (Event.startDate > (NOW()+6-$dateValue) 
   				AND Event.startDate < (NOW()+13-$dateValue)) 
               AND (EventType.Service = 1)
   				OR Event.Recurring = 'T'";

      $stmt = $db->prepare($sql);

      $stmt->execute();

      print_r($stmt->errorInfo());
}

function serviceNextWeekToOccurrence(){
      $db = newPDO();
      $db->beginTransaction();

      $sql = "INSERT Occurrence (S_Id,E_Id,startTime,endTime,Max,eventStatus_Id)
               SELECT S_Id,E_Id,startTime,endTime,Max,eventStatus_Id
               FROM ServiceNextWeek";

      $stmt = $db->prepare($sql);
      $stmt->execute();

      $db->exec("DELETE FROM ServiceNextWeek");

      $db->commit();

      print_r($stmt->errorInfo());
}

//populateServiceNextWeek();
serviceNextWeekToOccurrence();

















