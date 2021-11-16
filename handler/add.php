<?php
require "../dbBroker.php";
require "../model/task.php";

if(isset($_POST['title']) && isset($_POST['priority']) && $_POST['title'] != ""){
    $task = new Task(null, $_POST['title'], $_POST['description'], $_POST['priority'], $_POST['user_id']);
    $status = Task::add($task, $conn);

    if($status){
        echo 'Success';
    }else{
        echo "Failed";
    }
}
?>