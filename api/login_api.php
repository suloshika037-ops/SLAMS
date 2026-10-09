<?php

header("Content-Type: application/json");

include "../config/db.php";

$data = json_decode(
file_get_contents("php://input"),
true);

if(
!isset($data['email']) ||
!isset($data['password'])){
    echo json_encode([
        "status"=>"error",
        "message"=>"Email and password required"]);
exit();}

$email=$data['email'];
$password=$data['password'];

$stmt=$conn->prepare("SELECT * FROM users WHERE email=?");

$stmt->bind_param("s",$email);

$stmt->execute();

$result=$stmt->get_result();

if($result->num_rows==0){
    echo json_encode([
        "status"=>"error",
        "message"=>"User not found"]);
exit();}

$user=$result->fetch_assoc();

if(password_verify($password,$user['password'])){
    echo json_encode([
        "status"=>"success",
        "message"=>"Login Successful",
        "user_id"=>$user['id'],
        "name"=>$user['name'],
        "email"=>$user['email'],
        "role"=>$user['role']]);}

else{
    echo json_encode([
        "status"=>"error",
        "message"=>"Invalid Password"]);}

?>