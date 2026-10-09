<?php
session_start();

$conn = new mysqli("localhost","root","","slams_db");

if($conn->connect_error){
    die("Database Connection Failed");
}

function authenticateUser($email,$password){

    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();

    $result=$stmt->get_result();

    if($result->num_rows>0){

        $user=$result->fetch_assoc();

        if(password_verify($password,$user['password'])){

            return $user;

        }

    }

    return false;

}
?>