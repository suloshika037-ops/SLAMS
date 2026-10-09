<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT loans.*, users.name
FROM loans
INNER JOIN customers ON loans.customer_id = customers.id
INNER JOIN users ON customers.user_id = users.id
WHERE loans.id=?");

$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows==0){

die("<h3>Loan Not Found</h3>");

}

$row = $result->fetch_assoc();

?>

<div class="content">

<div class="card p-4">

<h3 class="mb-4">Loan Details</h3>

<table class="table table-bordered">

<tr>

<th width="250">Customer</th>

<td><?= $row['name']; ?></td>

</tr>

<tr>

<th>Loan Amount</th>

<td>Rs. <?= number_format($row['amount'],2); ?></td>

</tr>

<tr>

<th>Interest Rate</th>

<td><?= $row['interest_rate']; ?>%</td>

</tr>

<tr>

<th>Status</th>

<td><?= $row['status']; ?></td>

</tr>

</table>

<a href="loan_list.php" class="btn btn-secondary">

Back

</a>

</div>

</div>

<?php include "../includes/footer.php"; ?>
