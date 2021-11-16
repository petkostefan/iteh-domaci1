<?php

date_default_timezone_set("Europe/Belgrade");

class Task{
    public $id;
    public $naslov;
    public $opis;
    public $prioritet;
    public $vreme;
    public $user_id;

    public function __construct($id=null, $naslov=null, $opis=null, $prioritet=null, $user_id=null)
    {
        $this->id = $id;
        $this->naslov = $naslov;
        $this->opis = $opis;
        $this->prioritet = $prioritet;
        $this->user_id = $user_id;
        $this->vreme = null;
    }
    

    public static function add(Task $task, mysqli $conn){
        $query = "INSERT INTO task(naslov, opis, prioritet, user) 
        VALUES('$task->naslov','$task->opis','$task->prioritet','$task->user_id')";
        return $conn->query($query);
    }

    public static function getById($id, mysqli $conn){
        $query = "SELECT * FROM task WHERE id=$id";
        $myArray = array();
        $result = $conn->query($query);
        if($result){
            while($row = $result->fetch_array()){
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public static function getByUser($userid, mysqli $conn){
        $query = "SELECT * FROM task WHERE user=$userid";
        $myArray = array();
        $result = $conn->query($query);
        if($result){
            while($row = $result->fetch_array()){
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public function update(mysqli $conn){
        $query = "UPDATE task SET naslov ='$this->naslov', opis ='$this->opis', prioritet ='$this->prioritet' WHERE id='$this->id'";
        return $conn->query($query);
    }

    public function delete(mysqli $conn){
        $query = "DELETE FROM task WHERE id=$this->id";
        return $conn->query($query);
    }

}

?>