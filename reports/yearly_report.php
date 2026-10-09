
<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

$year = date('Y');

$loanResult = $conn->query("
SELECT COUNT(*) AS total_loans
FROM loans
WHERE YEAR(created_at)='$year'
")->fetch_assoc();

$paymentResult = $conn->query("
SELECT SUM(amount) AS total_payments
FROM payments
WHERE YEAR(paid_date)='$year'
")->fetch_assoc();

?>

<div class="content">

<div class="container-fluid">

<div class="card shadow p-4">

<h2 class="mb-4">

Yearly Report

</h2>

<table class="table table-bordered">

<tr>

<th>Report Year</th>

<td><?= $year; ?></td>

</tr>

<tr>

<th>Total Loans</th>

<td><?= $loanResult['total_loans']; ?></td>

</tr>

<tr>

<th>Total Payments</th>

<td>

Rs.
<?= number_format($paymentResult['total_payments'] ?? 0,2); ?>

</td>

</tr>

</table>

<h4 class="mt-4">

Loans Created This Year

</h4>

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>Loan ID</th>

<th>Customer ID</th>

<th>Amount</th>

<th>Status</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php

$loans = $conn->query("
SELECT *
FROM loans
WHERE YEAR(created_at)='$year'
ORDER BY id DESC
");

if($loans->num_rows>0){

while($row=$loans->fetch_assoc()){

?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['customer_id']; ?></td>

<td>Rs. <?= number_format($row['amount'],2); ?></td>

<td><?= $row['status']; ?></td>

<td><?= $row['created_at']; ?></td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="5" class="text-center">

No Records Found

</td>

</tr>

<?php

}

?>

</tbody>

</table>
<a href="reports.php"
class="btn btn-secondary">

Back

</a>
</div>

</div>

</div>

<?php

include "../includes/footer.php";

?>