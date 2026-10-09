<?php

include "../config/auth.php";
include "../includes/auth_check.php";

if(!isset($_GET['id'])){
    header("Location: customer_list.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM customers WHERE id=?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    header("Location: customer_list.php");
    exit();

}else{
    echo "<div class='alert alert-danger'>
    Delete Failed
    </div>";
}

?>