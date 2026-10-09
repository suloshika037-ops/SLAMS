<?php

header("Content-Type: application/json");

include "../config/db.php";

$customers = $conn->query("SELECT COUNT(*) AS total FROM customers")->fetch_assoc();
$loans = $conn->query("SELECT COUNT(*) AS total FROM loans")->fetch_assoc();
$active = $conn->query("SELECT COUNT(*) AS total FROM loans WHERE status='Approved'")->fetch_assoc();
$pending = $conn->query("SELECT COUNT(*) AS total FROM loans WHERE status='Pending'")->fetch_assoc();
$payments = $conn->query("SELECT SUM(amount) AS total FROM payments")->fetch_assoc();

echo json_encode([
    "status"=>"success",
    "report"=>[
        "total_customers"=>$customers['total'],
        "total_loans"=>$loans['total'],
        "active_loans"=>$active['total'],
        "pending_loans"=>$pending['total'],
        "total_payments"=>$payments['total'] ?? 0]]);

?>