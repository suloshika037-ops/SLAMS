<?php

include "../config/auth.php";
include "../includes/auth_check.php";


if(isset($_GET['id'])){

$id = intval($_GET['id']);

$stmt = $conn->prepare("UPDATE loans SET status='Approved' WHERE id=?");
$stmt->bind_param("i",$id);

if($stmt->execute()){
addAuditLog($conn, "Approved Loan");
header("Location: loan_list.php");

exit();

}else{

echo "Approval Failed";

}

}

?>

