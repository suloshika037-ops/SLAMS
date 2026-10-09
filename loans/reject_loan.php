<?php

include "../config/auth.php";
include "../includes/auth_check.php";


if(isset($_GET['id'])){

$id = intval($_GET['id']);

$stmt = $conn->prepare("UPDATE loans SET status='Rejected' WHERE id=?");
$stmt->bind_param("i",$id);

if($stmt->execute()){

header("Location: loan_list.php");

exit();

}else{

echo "Reject Failed";

}

}

?>
