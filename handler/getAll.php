<?php

require "../dbBroker.php";
require "../model/task.php";

$response = Task::getByUser($_GET['user_id'], $conn);
echo json_encode($response)
?>