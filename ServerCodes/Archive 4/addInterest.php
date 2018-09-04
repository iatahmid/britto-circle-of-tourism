<?php

/**
 * @author Taha
 */

require_once 'include/DB_Functions_Event.php';
$db = new DB_Functions_Event();

// json response array
$response = array("error" => FALSE);

if(!isset($_POST['event_id'])){
    $response["event"] = "missing";
}

if(!isset($_POST['user_id'])){
    $response["user"] = "missing";
}

if (isset($_POST['event_id']) && isset($_POST['user_id'])) {

    // receiving the post params
    $event = $_POST['event_id'];
    $user = $_POST['user_id'];
    
    // create a new interest
    $interest = $db->addInterest($event, $user);
    
    if ($interest) {
        // interest stored successfully
        $response["error"] = FALSE;
        $response["iid"] = $interest["id"];
        $response["interest"]["event_id"] = $interest["event_id"];
        $response["interest"]["user_id"] = $interest["user_id"];
        
        echo json_encode($response);
    } else {
        // event failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in storing interest!";

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

