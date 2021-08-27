<?php

function getOrders()
{
    $servername = "docker-lamp_db_1";
    $username = "web_user";
    $password = "theL3ss3rWeevil"; 
    $dbname = "sweetwater_test";


    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM sweetwater_test";
    $result = $conn->query($sql);

    return $result;
}

function updateExpectedDate($orderId)
{




    
}