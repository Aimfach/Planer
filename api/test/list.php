<?php

include 'dataManager.php';
$resultData = getEndData(userExists());
echo json_encode(['data'=>$resultData]);

/*
if(($result = getEndData('0')) != "failed")
{
  echo json_encode(['data'=>$result]);
} else {
  http_response_code(404);
}


*/

?>