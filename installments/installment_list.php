<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

$sql = "SELECT installments.*,loans.customer_id,users.name FROM installments
INNER JOIN loans ON installments.loan_id = loans.id
INNER JOIN customers ON loans.customer_id = customers.id
INNER JOIN users ON customers.user_id = users.id
ORDER BY installments.id DESC";
$result = $conn->query($sql);
?>

<div class="content">
<div class="card shadow p-4">
<div class="d-flex justify-content-between align-items-center mb-4">

<h3>Installment Schedule</h3>

<a href="generate_installment.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i>Generate Installment</a>
</div>

<table class="table table-bordered table-hover">

<thead>
<tr>

<th>ID</th>
<th>Loan ID</th>
<th>Customer</th>
<th>Installment No</th>
<th>Due Date</th>
<th>Amount</th>
<th>Status</th>

</tr>
</thead>

<tbody>

<?php
if($result && $result->num_rows > 0){while($row = $result->fetch_assoc()){
?>

<tr>
<td><?= $row['id']; ?></td>
<td><?= $row['loan_id']; ?></td>
<td><?= $row['name']; ?></td>
<td><?= $row['installment_no']; ?></td>
<td><?= $row['due_date']; ?></td>
<td>Rs. <?= number_format($row['amount'],2); ?></td>

<td>
<?php
if($row['status']=="Paid"){
    echo "<span class='badge bg-success'>Paid</span>";}
elseif($row['status']=="Partial"){
    echo "<span class='badge bg-warning text-dark'>Partial</span>";}
else{
    echo "<span class='badge bg-danger'>Unpaid</span>";}
?>
</td>
</tr>

<?php
}
}
else{
?>

<tr>
<td colspan="7" class="text-center">No Installments Found</td>
</tr>

<?php
}
?>

</tbody>
</table>
</div>
</div>

<?php
include "../includes/footer.php";
?>