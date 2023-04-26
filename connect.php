<?php
$servername =  'localhost';
$username = 'root';
$password = '';
$conn = new mysqli($servername,$username,$password);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

$sql = "CREATE DATABASE if not exists abc12c2208l";

try{
    $res = $conn->query($sql);
}catch(Exception $ex){
    echo $ex->getMessage();
}

$conn->select_db('abc12c2208l');
// $conn = new mysqli($servername,$username,$password,'abc12c2208l');

$sql = "CREATE TABLE if not exists abc12users (
    username VARCHAR(100) unique,
    password_hash VARCHAR(40),
    phone varchar(10)
    )";

try{
    $res = $conn->query($sql);
    if(!$res){
        echo "Error creating table: " . $conn->error;
        die();
    }
}
catch(Exception $ex){
    echo $ex->getMessage();
    die();
}

