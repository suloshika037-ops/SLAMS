<?php

header("Content-Type: application/json");

include "../config/db.php";


$sql = 
"SELECT loans.id,
customers.id AS customer_id,
users.name AS customer_name,
loans.amount,
loans.interest_rate,
loans.total_repayale,
loans.outstanding_balance,
loans.status,
loans.created_at FROM loans

INNER JOIN customers ON loans.customer_id = customers.id
INNER JOIN users ON customers.user_id = users.id
ORDER BY loans.id DESC";

$result=$conn->query($sql);
$loans=[];
if($result->num_rows > 0){
while($row=$result->fetch_assoc()){
$loans[]=$row;
}}

echo json_encode([
"status"=>"success",
"data"=>$loans
]);

?>