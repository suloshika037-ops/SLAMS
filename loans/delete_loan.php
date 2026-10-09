
<?php

include "../config/auth.php";


if(isset($_GET['id'])){
$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM loans WHERE id=?");
$stmt->bind_param("i",$id);

if($stmt->execute()){
header("Location: loan_list.php");
exit();
}else{
echo "Delete Failed";
}
}
?>