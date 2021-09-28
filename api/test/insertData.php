<?php
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {

    include 'dataManager.php';

    $postdata = file_get_contents("php://input");

    $request = json_decode($postdata);
    $patientID = trim($request->patientID);
    $code = trim($request->code);
    $date = trim($request->date);
    
    //$username = "admin";
    //$password = "admin";
    $resultData = setInBase($code, $date, $patientID, userExists());
    echo json_encode(['data' => $resultData]);
} else {
    $resultData = "Error";

    echo json_encode(['data'=>$resultData]);
}
