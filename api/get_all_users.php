<?php
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {

    include 'UserManager.php';

    $postdata = file_get_contents("php://input");

    $request = json_decode($postdata);
    $date = trim($request->patientID);

    $resultData = get_all_user_data($date);
    echo json_encode(['data' => $resultData]);

} else {
    $resultData = "Error";

    echo json_encode(['data'=>$resultData]);
}
