<?php
require "../dbBroker.php";
require "../model/task.php";

if(isset($_POST['id'])){
    $task = new Task($_POST['id']);
    $status = $task->delete($conn);

    if($status){
        echo 'Success';
    }else{
        echo "Failed";
    }
}
?>