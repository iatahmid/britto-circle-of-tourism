<?php
  require_once 'include/DB_Functions_Event.php';

  $db = new DB_Functions_Event();
  $events = $db->getEvents();
  $eArr = json_decode($events, true);
  //print_r($eArr);
  for ($i=0; $i < sizeof($eArr); $i++) { 
    echo $eArr[$i]['name'];
  }
?>