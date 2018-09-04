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
        
        $stmt = $this->conn->prepare("INSERT INTO event(name, place, start_date, num_of_days, budget, moderator, contact, details) 
                                        VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiisss", $name, $place, $start_date, $num_of_days, $budget, $moderator, $contact, $details);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            /*$stmt = $this->conn->prepare("SELECT * FROM event WHERE unique_id = ?");
            $stmt->bind_param("s", $ueid);
            $stmt->execute();
            $event = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $event;*/
            return true;
        } else {
            return false;
        }
    }

    public function updateEvent($id, $name, $place, $start_date, $num_of_days, $budget, $moderator, $contact, $details) {

        $stmt = $this->conn->prepare("UPDATE event
                                        SET name = ?, place = ?, start_date = ?, num_of_days = ?, 
                                        budget = ?, moderator = ?, contact = ?, details = ?
                                        WHERE id = ?");
        $stmt->bind_param("sssiisssi", $name, $place, $start_date, $num_of_days, $budget, $moderator, $contact, $details, $id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            /*$stmt = $this->conn->prepare("SELECT * FROM event WHERE unique_id = ?");
            $stmt->bind_param("s", $ueid);
            $stmt->execute();
            $event = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $event;*/
            return true;
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
     * Storing new interest
     * returns interest details
     */
    public function addInterest($event, $user) {
        
        $stmt1 = $this->conn->prepare("SELECT * FROM interest WHERE event_id = ? AND user_id = ?");
        $stmt1->bind_param("ii", $event, $user);
        $stmt1->execute();
        $stmt1->store_result();

        if ($stmt1->num_rows == 0) {

            $stmt1->close();

            $stmt = $this->conn->prepare("INSERT INTO interest(event_id, user_id) 
                                            VALUES(?, ?)");
            $stmt->bind_param("ii", $event, $user);
            $result = $stmt->execute();
            $stmt->close();

            // check for successful store
            if ($result) {
                $stmt = $this->conn->prepare("SELECT * FROM interest WHERE event_id = ? AND user_id = ?");
                $stmt->bind_param("ii", $event, $user);
                $stmt->execute();
                $interest = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                return $interest;
            } else {
                return false;
            }

        }

    }




    public function createInterestTable() {

        $query = "CREATE TABLE interest (
                        id INT( 10 ) NOT NULL AUTO_INCREMENT ,
                        event_id INT( 10 ) NOT NULL ,
                        user_id INT( 10 ) NOT NULL ,
                        PRIMARY KEY ( id ) ,
                        UNIQUE (
                         id 
                        )
                    )";


        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }
    }


    public function getAllInterests() {

        $query = "SELECT * from interest";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $row_array['id'] = $row['id'];
            $row_array['event_id'] = $row['event_id'];
            $row_array['user_id'] = $row['user_id'];

            array_push($return_array, $row_array);
        }

        echo json_encode($return_array);
        //echo $return_array;

        //$link->close();

    }

    public function createEventTable() {

        $query = "CREATE TABLE event (
                        id INT( 10 ) NOT NULL AUTO_INCREMENT ,
                        name VARCHAR( 50 ) NOT NULL ,
                        place VARCHAR( 50 ) NOT NULL ,
                        start_date DATE NOT NULL ,
                        num_of_days INT( 10 ) NOT NULL ,
                        budget INT( 10 ) NOT NULL ,
                        moderator VARCHAR( 50 ) NOT NULL ,
                        contact VARCHAR( 50 ) NOT NULL ,
                        details VARCHAR( 200 ) NOT NULL ,
                        PRIMARY KEY ( id ) ,
                        UNIQUE (
                         id 
                        )
                    ) 
                    ";


        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }
    }
    /**
     * Getting All Events
     * returns event details
     */
    public function getAllEvents() {

        $query = "SELECT * from event";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $row_array['id'] = $row['id'];
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
        //echo $return_array;

        //$link->close();

    }



    public function createUserTable() {

        $query = "create table users(
                       id int(11) primary key auto_increment,
                       unique_id varchar(23) not null unique,
                       name varchar(50) not null,
                       email varchar(100) not null unique,
                       encrypted_password varchar(80) not null,
                       salt varchar(10) not null,
                       created_at datetime,
                       updated_at datetime null
                    )
                    ";


        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }
    }

    public function getAllUsers() {

        $query = "SELECT * from users";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $row_array['id'] = $row['id'];
            $row_array['unique_id'] = $row['unique_id'];
            $row_array['name'] = $row['name'];
            $row_array['email'] = $row['email'];

            $row_array['created_at'] = $row['created_at'];
            $row_array['is_admin'] = $row['is_admin'];

            array_push($return_array, $row_array);
        }

        echo json_encode($return_array);
        /*echo "<pre>";
        echo $return_array;
        echo "<pre>";
*/
        //$link->close();

    }

    public function runQuery() {

        $query = "UPDATE users SET is_admin = 1 WHERE id = 1";

        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }
     
    }

    }

?>