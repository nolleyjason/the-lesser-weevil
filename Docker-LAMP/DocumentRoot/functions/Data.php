<?php

function openDBConn()
{
    $servername = "docker-lamp_db_1";
    $username = "web_user";
    $password = "theL3ss3rWeevil"; 
    $dbname = "sweetwater_test";

    return new mysqli($servername, $username, $password, $dbname);

}

function closeDBConn($connection)
{
    $connection->close();
}


function getOrders()
{

    $conn = openDBConn();

    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM sweetwater_test ORDER BY orderid ASC";
    $result = $conn->query($sql);

    closeDBConn($conn);

    return $result;
}

function updateExpectedDate($orderId,$expectedDate)
{

    $conn2 = openDBConn();

    if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
    }

    $sql = "UPDATE sweetwater_test SET shipdate_expected = '".$expectedDate."' WHERE orderid = ".$orderId;
    $result = $conn2->query($sql);

    closeDBConn($conn2);

    return $result;



}