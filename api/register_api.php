<?php

header("Content-Type: application/json");

include "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if(
    !isset($data['name']) ||
    !isset($data['email']) ||
    !isset($data['password']) ||
    !isset($data['role']))
{
    echo json_encode([
        "status"=>"error",
        "message"=>"Missing required fields"]);
exit();}

$name = $data['name'];
$email = $data['email'];
$password = $data['password'];
$role = $data['role'];

$check = $conn->prepare("SELECT id FROM users WHERE email=?");

$check->bind_param("s",$email);

$check->execute();

$result = $check->get_result();

if($result->num_rows > 0){
    echo json_encode([
        "status"=>"error",
        "message"=>"Email already exists"]);
exit();}

$hashPassword = password_hash($password,PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users(name,email,password,role)VALUES (?,?,?,?)");

$stmt->bind_param("ssss",$name,$email,$hashPassword,$role);

if($stmt->execute()){
    echo json_encode([
        "status"=>"success",
        "message"=>"User Registered Successfully",
        "user_id"=>$stmt->insert_id]);
}
else{
    echo json_encode([
        "status"=>"error",
        "message"=>"Registration Failed"]);
}

?>