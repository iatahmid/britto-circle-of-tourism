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


    public function formatDate($date){
        list($day, $month, $year) = split('[/.-]', $date);
        
        if($day < 10){
            $day = '0'.$day;
        }
        if($month < 10){
            $month = '0'.$month;
        }
        
        $dateFormat = $day . '-' . $month . '-' . $year;

        return $dateFormat;
    }

    public function reFormatDate($date){
        list($year, $month, $day) = split('[/.-]', $date);
        
        if($year > 31){
            $dateFormat = $day . '-' . $month . '-' . $year;
            return $dateFormat;
        }

        else{
            return $date;
        }
    }
    /**
     * Storing new event
     * returns event details
     */
    public function storeEvent($name, $place, $start_date, $end_date, $budget, $moderator, $contact, $details) {

        //$ueid = uniqid('', true);
        //$dateFormat = $this->formatDate($start_date);

        $start_date = $this->formatDate($start_date);
        $end_date = $this->formatDate($end_date);

        $stmt = $this->conn->prepare("INSERT INTO event(name, place, start_date, end_date, budget, moderator, contact, details) 
                                        VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisss", $name, $place, $start_date, $end_date, $budget, $moderator, $contact, $details);
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

    public function updateEvent($id, $name, $place, $start_date, $end_date, $budget, $moderator, $contact, $details) {

        $start_date = $this->formatDate($start_date);
        $end_date = $this->formatDate($end_date);

        $stmt = $this->conn->prepare("UPDATE event
                                        SET name = ?, place = ?, start_date = ?, end_date = ?, 
                                        budget = ?, moderator = ?, contact = ?, details = ?
                                        WHERE id = ?");
        $stmt->bind_param("ssssisssi", $name, $place, $start_date, $end_date, $budget, $moderator, $contact, $details, $id);
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

    public function getInterstedUsersInEvent($event_id){
        $stmt1 = $this->conn->prepare("SELECT * FROM interest WHERE event_id = ?");
        $stmt1->bind_param("i", $event_id);
        $stmt1->execute();
        $result = $stmt1->get_result();
        $stmt1->close();

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $user_id = $row['user_id'];

            $stmt2 = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt2->bind_param("i", $user_id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $stmt2->close();

            while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
                
                $row_array['id'] = $row2['id'];
                $row_array['name'] = $row2['name'];
                $row_array['email'] = $row2['email'];
                $row_array['contact'] = $row2['contact'];

                $row_array['is_admin'] = $row2['is_admin'];

                array_push($return_array, $row_array);
            }
        }

        echo json_encode($return_array);
    }

    public function uploadImage($event_id, $name, $image) {
        
        require_once 'Config.php';

        $img_path = ROOT_PATH . "/images/$name.jpg";

        $stmt = $this->conn->prepare("INSERT INTO Image(event_id, img_path) 
                                        VALUES(?, ?)");
        $stmt->bind_param("is", $event_id, $img_path);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            file_put_contents($img_path, base64_decode($image));
            return true;
        } else {
            return false;
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
    public function getUpcomingEvents() {

        $query = "SELECT * from event WHERE start_date >= CURDATE() ORDER BY start_date ASC";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();
 
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $sd = $row['start_date'];
            $ed = $row['end_date'];
            $nsd = $this->reFormatDate($sd);
            $ned = $this->reFormatDate($ed);

            $row_array['id'] = $row['id'];
            $row_array['name'] = $row['name'];
            $row_array['place'] = $row['place'];
            $row_array['start_date'] = $nsd;
            $row_array['end_date'] = $ned;

            $row_array['budget'] = $row['budget'];
            $row_array['moderator'] = $row['moderator'];
            $row_array['contact'] = $row['contact'];
            $row_array['details'] = $row['details'];

            $row_array['capacity'] = $row['capacity'];            

            array_push($return_array, $row_array);
        }

        echo json_encode($return_array);
    }

    public function getPastEvents() {

        $query = "SELECT * from event where start_date < CURDATE() ORDER BY start_date DESC";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();
 
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $row_array['id'] = $row['id'];
            $row_array['name'] = $row['name'];
            $row_array['place'] = $row['place'];
            $row_array['start_date'] = $row['start_date'];
            $row_array['end_date'] = $row['end_date'];

            $row_array['num_of_days'] = $row['num_of_days'];
            $row_array['budget'] = $row['budget'];
            $row_array['moderator'] = $row['moderator'];
            $row_array['contact'] = $row['contact'];
            $row_array['details'] = $row['details'];

            $row_array['capacity'] = $row['capacity'];            

            array_push($return_array, $row_array);
        }

        echo json_encode($return_array);
    }

    public function deleteEvent($id) {

        $stmt = $this->conn->prepare("DELETE from event
                                        WHERE id = ?");
        $stmt->bind_param("i", $id);
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

            $row_array['contact'] = $row['contact'];
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

    public function createImgTable() {

        $query = "CREATE TABLE Image (
                id INT( 10 ) NOT NULL AUTO_INCREMENT,
                event_id INT( 10 ) NOT NULL,
                img_path VARCHAR( 200 ) NOT NULL,
                PRIMARY KEY (id),
                UNIQUE (id)
                )";

        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }
    }

    public function getAllImages() {

        $query = "SELECT * from Image";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $row_array['id'] = $row['id'];
            $row_array['event_id'] = $row['event_id'];
            /*$row_array['img'] = $row['img_path'];*/
            $row_array['img'] = base64_encode(file_get_contents($row['img_path']));

            array_push($return_array, $row_array);
        }

        echo json_encode($return_array);
    }


    public function setAdmin($email){
        $query = "UPDATE users SET is_admin = 1 
                                     WHERE email = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $result = $stmt->execute();
        $stmt->close();

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }        
    }

    public function runQuery() {

        $query = "ALTER TABLE event ADD COLUMN capacity INT(5) AFTER end_date";

        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }
/*      $email = "admin@britto.com";
        $this->setAdmin($email);        */
    }

    }

?>