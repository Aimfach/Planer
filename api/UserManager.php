<?php
function get_user_details($date, $user_id)
{
    $servername = "localhost:3306";
    $username = "root";
    $password = "";
    $dbname = "planer_database";

    try {

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM covid_status, user_present WHERE covid_status.user_id=:user_id AND user_present.user_id=:user_id AND user_present.date=:date_given");

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':date_given', $date);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();
            $res['vaccinated'] = $result['vaccinated'];
            $res['last_self_test'] = $result['last_self_test'];
            $res['present'] = $result['present'];
            $res['excused'] = $result['excused'];

            return $res;
        } else {

            return null;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
    $conn = null;


}

function get_all_user_data($date)
{
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
                $tmp = get_user_details($date, $result['id']);
                $res[$counter] = array_merge($res[$counter], $tmp);
                $counter = $counter + 1;
                echo $counter;
            }
            echo json_encode(['data' => $res]);
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

function set_user_covid_status($key, $value, $user_id)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Abrechnung";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("INSERT INTO covid_status (" + $key + ", user_id) VALUES (:value, :userid);");

        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();
        return "success";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return "Error: " . $e->getMessage();
    }
    $conn = null;


}