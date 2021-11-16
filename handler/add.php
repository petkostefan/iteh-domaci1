<?php
require "../dbBroker.php";
require "../model/task.php";

if(isset($_POST['title']) && isset($_POST['priority']) && $_POST['title'] != "" && $_POST['priority'] != ""){
    if($_POST['priority'] < 0 || $_POST['priority'] >10){
        echo "fieldError";
    }else{

        $task = new Task(null, $_POST['title'], $_POST['description'], $_POST['priority'], $_POST['user_id']);
        $status = Task::add($task, $conn);

        if($status){
            echo 'Success';
        }else{
            echo "Failed";
        }
    }
}else{
    echo "emptyError";
}
?>