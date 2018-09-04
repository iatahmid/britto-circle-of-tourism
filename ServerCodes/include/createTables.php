<?php

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

    public function createEventTable() {

        $query = "CREATE TABLE event (
                        id INT( 10 ) NOT NULL AUTO_INCREMENT ,
                        name VARCHAR( 50 ) NOT NULL ,
                        place VARCHAR( 50 ) NOT NULL ,
                        start_date DATE NOT NULL ,
                        end_date DATE NOT NULL ,
                        capacity INT( 10 ) NOT NULL ,
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

    public function createPlaceTable(){
        $query = "create table place(
                       id int(11) primary key auto_increment,
                       name varchar(200) not null,
                       details TEXT,
                       link varchar(300),
                       UNIQUE(id)
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

?>