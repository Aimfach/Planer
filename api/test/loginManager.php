<?php
function gen_uuid()
{
    $uuid = array(
        'time_low'  => 0,
        'time_mid'  => 0,
        'time_hi'  => 0,
        'clock_seq_hi' => 0,
        'clock_seq_low' => 0,
        'node'   => array()
    );

    $uuid['time_low'] = mt_rand(0, 0xffff) + (mt_rand(0, 0xffff) << 16);
    $uuid['time_mid'] = mt_rand(0, 0xffff);
    $uuid['time_hi'] = (4 << 12) | (mt_rand(0, 0x1000));
    $uuid['clock_seq_hi'] = (1 << 7) | (mt_rand(0, 128));
    $uuid['clock_seq_low'] = mt_rand(0, 255);

    for ($i = 0; $i < 6; $i++) {
        $uuid['node'][$i] = mt_rand(0, 255);
    }

    $uuid = sprintf(
        '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
        $uuid['time_low'],
        $uuid['time_mid'],
        $uuid['time_hi'],
        $uuid['clock_seq_hi'],
        $uuid['clock_seq_low'],
        $uuid['node'][0],
        $uuid['node'][1],
        $uuid['node'][2],
        $uuid['node'][3],
        $uuid['node'][4],
        $uuid['node'][5]
    );
    return $uuid;
}

function hashStr($str)
{

    function myMd5($str, $iterations)
    {

        $salt = 'ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4';

        for ($x = 0; $x < $iterations; $x++) {
            $str = md5($str . $salt);
        }
        return $str;
    }

    return myMd5($str, 1);
}

function accountExists($accNameIn, $accPassIn)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Abrechnung";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT password FROM user WHERE usrname=:usr");

        $stmt->bindParam(':usr', $accNameIn);

        $res = $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $res = $stmt->fetchAll()[0];
            if ($res[0] == hashStr($accPassIn)) {

                $uuid = gen_uuid();
                $conn->exec("UPDATE user SET uuid = '" . $uuid . "' WHERE usrname = '" . $accNameIn . "'");

                $_SESSION['id'] = $uuid;


                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}
