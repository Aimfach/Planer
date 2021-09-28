<?php
/*
function getDropdownData()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Abrechnung";

    try {

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT code, name FROM codes ORDER BY code";
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $counter = 0;
            while ($result = $stmt->fetch()) {
                $res[$counter] = $result['code'] . "-" . $result['name'];
                ++$counter;
            }
            return $res;
        } else {
            echo "failed<br>";
            return null;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
    $conn = null;
}*/
function setInBase($number, $date, $id, $userID)
{
    $code = "";
    $i = 0;
    while ($number{
        $i} != "-") {
        $code = $code . $number{
            $i};
        ++$i;
    }


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
function userExists()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Abrechnung";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT id FROM user WHERE uuid=:uuid");

        $stmt->bindParam(':uuid', $_SESSION['id']);

        $res = $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $res = $stmt->fetchAll()[0];
            return $res[0];
        } else {
            return null;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}
function getEndData($userID)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Abrechnung";

    $codes = getCodeDataForFines();

    try {

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT code,patientID,date_format(date,'%d.%m.%Y') FROM fines WHERE userID=:userid AND done='0' ORDER BY patientID DESC, date");

        $stmt->bindParam(':userid', $userID);


        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $counter = 0;
            while ($result = $stmt->fetch()) {
                $res[$counter]['id'] = $result['patientID'];
                //echo $result['patientID'];
                $res[$counter]['date'] = $result['date_format(date,' . "'%d.%m.%Y'" . ')'];
                //echo $result['date_format(date,' . "'%d.%m.%Y'" . ')'];
                $res[$counter]['code'] = $result['code'];
                //echo $result['code'];
                $res[$counter]['name'] = $codes[$result['code']]['name'];
                //echo $codes[$result['code']]['name'];
                $res[$counter]['price'] = $codes[$result['code']]['price'];
                //echo $codes[$result['code']]['price'];
                $res[$counter]['privateprice'] = $codes[$result['code']]['privateprice'];
                //echo $codes[$result['code']]['privateprice'];
                ++$counter;
            }
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
function getCodeDataForFines()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Abrechnung";

    try {

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT code, name, price, privateprice FROM codes ORDER BY code";
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
            while ($result = $stmt->fetch()) {
                $res[$result['code']]['name'] = $result['name'];
                $res[$result['code']]['price'] = $result['price'];
                $res[$result['code']]['privateprice'] = $result['privateprice'];
            }
            return $res;
        } else {
            echo "failed<br>";
            return null;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
    $conn = null;
}

function getCodeData()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Abrechnung";

    try {

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT code, name, price, privateprice FROM codes ORDER BY code";
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $counter = 0;
            while ($result = $stmt->fetch()) {
                $res[$counter]['code'] = $result['code'];
                $res[$counter]['name'] = $result['name'];
                $res[$counter]['price'] = $result['price'];
                $res[$counter]['privateprice'] = $result['privateprice'];
                ++$counter;
            }
            return $res;
        } else {
            echo "failed<br>";
            return null;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
    $conn = null;
}

function changeFine($fineId, $patientId, $code, $date) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Abrechnung";

    $userId = userExists();
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE fines SET patientID=:patientId, date=:date, code=:code WHERE fineId=:fineId AND userID=:userId ");

        $stmt->bindParam(':fineId', $fineId);
        $stmt->bindParam(':patientId', $patientId);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':userId', $userId);
        
        $stmt->execute();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}
?>