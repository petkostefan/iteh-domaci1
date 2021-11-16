<?php
require "../dbBroker.php";
require "../model/task.php";

if(isset($_POST['title']) && isset($_POST['priority']) && $_POST['title'] != ""){
    $task = new Task($_POST['id'], $_POST['title'].' (uredjen)', $_POST['description'], $_POST['priority']);
    $status = $task->update($conn);

    if($status){
        echo 'Success';
    }else{
        echo "Failed";
    }
}
?>