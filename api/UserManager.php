<?php
get_all_users();
function setInBase($number, $date, $id, $userID)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Abrechnung";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("INSERT INTO fines (patientID, date, code, userID) VALUES (:id, :date, :code, :userid);");

        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':userid', $userID);

        $stmt->execute();
        return "success";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return "Error: " . $e->getMessage();
    }
    $conn = null;

}

function get_user_details() {

}

function get_all_users() {
    $servername = "localhost:3306";
    $username = "root";
    $password = "";
    $dbname = "planer_database";

    try {

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM user");

        #$stmt->bindParam(':userid', $userID);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $counter = 0;
            print_r($result);
            while ($result = $stmt->fetch()) {
                $res[$counter]['id'] = $result['id'];
                $res[$counter]['name'] = $result['name'];
                $res[$counter]['pre_name'] = $result['pre_name'];
                $counter = $counter + 1;
                echo $counter;
            }
            print_r($res);
            return $res;
        } else {
            echo "failed";
            echo "njaaaa";
            return null;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
    $conn = null;
}

