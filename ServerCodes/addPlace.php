<?php

/**
 * @author Taha
 */

require_once 'include/DB_Functions_Event.php';
$db = new DB_Functions_Event();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['name'])) {

    /*db->storeTestEvent();*/

    // receiving the post params
    $name = $_POST['name'];

    if(isset($_POST['details'])) $details = $_POST['details'];
    else $details = " ";

    if(isset($_POST['link'])) $link = $_POST['link'];
    else $link = " ";

    $place = $db->storePlace($name, $details, $link);
    
    if ($place) {
        // event stored successfully
        $response["error"] = FALSE;
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

