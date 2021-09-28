<?php
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {

    include 'loginManager.php';

    $postdata = file_get_contents("php://input");

    $request = json_decode($postdata);
    $username = trim($request->username);
    $password = trim($request->password);
    
    //$username = "admin";
    //$password = "admin";
    $resultData = accountExists($username, $password);
    echo json_encode(['data' => $resultData]);
} else {
    $resultData = false;

    echo json_encode(['data'=>$resultData]);
}
