<?php

header("Content-Type: application/json");

include "../config/db.php";

$sql = 
"SELECT payments.id,payments.installment_id,payments.amount,payments.paid_date,
loans.id AS loan_id,
customers.id AS customer_id,
users.name AS customer_name FROM payments

INNER JOIN instalments ON payments.installment_id = instalments.id
INNER JOIN loans ON instalments.loan_id = loans.id
INNER JOIN customers ON loans.customer_id = customers.id
INNER JOIN users ON customers.user_id = users.id

ORDER BY payments.id DESC";

$result = $conn->query($sql);
$payments=[];

if($result->num_rows > 0){
while($row=$result->fetch_assoc()){
$payments[]=$row;}}

echo json_encode([
    "status"=>"success",
    "data"=>$payments]);

?>