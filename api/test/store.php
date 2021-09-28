<?php
$postdata = $_POST['data'];

if (isset($postdata) && !empty($postdata)) {
    include 'dataManager.php';
    //setInBase($postdata);
}

?>