<?php

/**
 * @author Taha
 */

require_once 'include/DB_Connect.php';
// connecting to database
$db = new Db_Connect();
$conn = $db->connect();

$query  = 'ALTER TABLE `event` CHANGE `moderator` `moderator` VARCHAR(300)';

$result = mysqli_query($conn, $query);
if($result){
    echo "SUCCESS";
}
else{
    echo "failed";
}

?>

