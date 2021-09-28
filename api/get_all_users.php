<?php
$postdata = file_get_contents("php://input");

include 'UserManager.php';

$resultData = get_all_users();
echo json_encode(['data' => $resultData]);
