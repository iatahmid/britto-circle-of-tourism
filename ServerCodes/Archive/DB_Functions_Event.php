<?php

class DB_Functions_Event {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {
        
    }


    /**
     * Storing new event
     * returns event details
     */
    public function storeEvent($name, $place, $start_date, $num_of_days, $budget, $moderator, $contact, $details) {

        $ueid = uniqid('', true);
        
        $stmt = $this->conn->prepare("INSERT INTO event(unique_id, name, place, start_date, num_of_days, budget, moderator, contact, details) 
                                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $ueid, $name, $place, $start_date, $num_of_days, $budget, $moderator, $contact, $details);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM event WHERE unique_id = ?");
            $stmt->bind_param("s", $ueid);
            $stmt->execute();
            $event = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $event;
        } else {
            return false;
        }
    }

    public function storeTestEvent() {

        $ueid = uniqid('', true);
        $a = "a";
        $b = "b";
        $c = "c";
        $d = "d";
        $e = "e";
        $f = "f";
        $g = "g";
        $h = "h";
        
        $stmt = $this->conn->prepare("INSERT into event(unique_id, name, place, start_date, num_of_days, budget, moderator, contact, details) 
                                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $uuid, $a, $b, $c, $d, $e, $f, $g, $h);
        $result = $stmt->execute();
        $stmt->close();

/*        $query = "INSERT into event(unique_id, name, place, start_date, num_of_days, budget, moderator, contact, details) 
                                        VALUES(123, a, b, c, d, e, f, g, h)");
        $result = mysqli_query($this->conn, $query);
*/        
    }



    /**
     * Getting All Events
     * returns event details
     */
    public function getAllEvents() {
        $conn = $this->conn;
        $query = "SELECT * from event";
        $result = mysqli_query($conn, $query);

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {

            $row_array['unique_id'] = $row['unique_id'];
            $row_array['name'] = $row['name'];
            $row_array['place'] = $row['place'];
            $row_array['start_date'] = $row['start_date'];

            $row_array['num_of_days'] = $row['num_of_days'];
            $row_array['budget'] = $row['budget'];
            $row_array['moderator'] = $row['moderator'];
            $row_array['contact'] = $row['contact'];
            
            $row_array['details'] = $row['details'];

            array_push($return_array, $row_array);

        }

        echo json_encode($return_array);
print "<pre>";
print_r($return_array);
print "</pre>";
        //$link->close();

    }

    }

?>