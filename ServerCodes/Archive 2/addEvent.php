<?php

/**
 * @author Taha
 */

require_once 'include/DB_Functions_Event.php';
$db = new DB_Functions_Event();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['name']) && isset($_POST['place']) && isset($_POST['start_date']) && isset($_POST['num_of_days'])
    && isset($_POST['budget']) && isset($_POST['moderator']) && isset($_POST['contact'])) {

    /*db->storeTestEvent();*/

    // receiving the post params
    $name = $_POST['name'];
    $place = $_POST['place'];
    $start_date = $_POST['start_date'];
    $num_of_days = $_POST['num_of_days'];
    $budget = $_POST['budget'];
    $moderator = $_POST['moderator'];
    $contact = $_POST['contact'];

    if(isset($_POST['details'])) $details = $_POST['details'];
    else $details = " ";

    // create a new user
    $event = $db->storeEvent($name, $place, $start_date, $num_of_days, $budget, $moderator, $contact, $details);
    
    if ($event) {
        // event stored successfully
        $response["error"] = FALSE;
        //$response["uid"] = $event["unique_id"];
        $response["event"]["name"] = $event["name"];
        $response["event"]["place"] = $event["place"];
        $response["event"]["start_date"] = $event["start_date"];
        $response["event"]["num_of_days"] = $event["num_of_days"];
        $response["event"]["budget"] = $event["budget"];
        $response["event"]["moderator"] = $event["moderator"];
        $response["event"]["contact"] = $event["contact"];
        $response["event"]["details"] = $event["details"];

        /*db->storeTestEvent();        */

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

