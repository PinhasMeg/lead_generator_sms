<?php

function getTokenApi(){
    $token = "TOKEN";
    return $token;
}


function getDeviceId(){
    $deviceId = "deviceId";
    return $deviceId;
}

function mysqlConnection() {
    $dbhost = "dbhost";
    $dbuser = "dbuser";
    $dbpass = "dbpass";
    $db = "db";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
    return $conn;
}

function closeConnection($conn) {
 $conn -> close();
}