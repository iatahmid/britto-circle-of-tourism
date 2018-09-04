<?php

/**
 * @author Taha
 */

require_once 'include/DB_Functions_Event.php';
$db = new DB_Functions_Event();

// json response array
$response = array("error" => FALSE);

if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['event_id']) && isset($_POST['name']) && isset($_POST['image'])) {

    /*db->storeTestEvent();*/

    // receiving the post params
    $event_id = $_POST['event_id'];
    $image = $_POST['image'];
    $name = $_POST['name'];

    // create a new user
    $image = $db->uploadImage($event_id, $name, $image);
    
    if ($image) {
        // event stored successfully
        $response["error"] = FALSE;

        echo json_encode($response);
    } else {
        // event failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in storing image!";

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

