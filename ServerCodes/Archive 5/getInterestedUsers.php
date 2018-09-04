<?php

/**
 * @author Taha
 */

require_once 'include/DB_Functions_Event.php';
$db = new DB_Functions_Event();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['event_id'])) {

    /*db->storeTestEvent();*/

    // receiving the post params
    $event_id = $_POST['event_id'];

    // 
    $result = $db->getInterstedUsersInEvent($event_id);

    if($result){
    	$response["error"] = FALSE;

		echo json_encode($response);    	
    }
    
}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters are porking each other!";
    
    /*db->storeTestEvent();*/

    echo json_encode($response);
}
?>

