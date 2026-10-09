
<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/audit_function.php";

if(!isset($_GET['id'])){
addAuditLog($conn, "Deleted User");
header("Location: ../admin/user_management.php");
exit();

}

$id=$_GET['id'];

/* Prevent deleting your own account */

if($_SESSION['user_id']==$id){

echo "<script>

alert('You cannot delete your own account.');

window.location='../admin/user_management.php';

</script>";

exit();

}

$stmt=$conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i",$id);

if($stmt->execute()){

header("Location: ../admin/user_management.php");

}else{

echo "Delete Failed";

}

?>