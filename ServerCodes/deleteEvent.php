<?php

/**
 * @author Taha
 */

require_once 'include/DB_Functions_Event.php';
$db = new DB_Functions_Event();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['id'])) {

    /*db->storeTestEvent();*/

    // receiving the post params
    $id = $_POST['id'];

    // 
    $result = $db->deleteEvent($id);
    
    if ($result) {
        $response["error"] = FALSE;
        //$response["uid"] = $event["unique_id"];

        echo json_encode($response);
    } else {
        // event failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in storing event!";

        /*db->storeTestEvent();*/

        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters are missing!";
    
    /*db->storeTestEvent();*/

    echo json_encode($response);
}
?>

