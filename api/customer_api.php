<?php

header("Content-Type: application/json");

include "../config/db.php";

$sql = 
"SELECT customers.id,users.name,users.email,customers.phone,customers.nic,customers.address FROM customers
INNER JOIN users ON customers.user_id = users.id
ORDER BY customers.id DESC";

$result = $conn->query($sql);
$customers = [];

if($result->num_rows > 0){
while($row = $result->fetch_assoc()){
$customers[] = $row;}}

echo json_encode([
    "status"=>"success",
    "data"=>$customers]);

?>