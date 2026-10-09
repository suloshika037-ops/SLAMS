<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

$sql = "SELECT loans.*, users.name
        FROM loans
        INNER JOIN customers ON loans.customer_id = customers.id
        INNER JOIN users ON customers.user_id = users.id
        ORDER BY loans.id DESC";

$result = $conn->query($sql);

?>

<div class="content">

<div class="card p-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h3>Loan Management</h3>

<a href="add_loan.php" class="btn btn-primary">
<i class="bi bi-plus-circle"></i>
Add Loan
</a>

</div>

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>ID</th>

<th>Customer</th>

<th>Amount</th>

<th>Interest %</th>

<th>Status</th>

<th width="260">Action</th>

</tr>

</thead>

<tbody>

<?php

if($result->num_rows>0){

while($row=$result->fetch_assoc()){

?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['name']; ?></td>

<td>Rs. <?= number_format($row['amount'],2); ?></td>

<td><?= $row['interest_rate']; ?>%</td>

<td>

<?php

if($row['status']=="Approved"){

echo "<span class='badge bg-success'>Approved</span>";

}elseif($row['status']=="Rejected"){

echo "<span class='badge bg-danger'>Rejected</span>";

}else{

echo "<span class='badge bg-warning text-dark'>Pending</span>";

}

?>

</td>

<td>

<a href="view_loan.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">

<i class="bi bi-eye"></i>

</a>

<a href="edit_loan.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">

<i class="bi bi-pencil-square"></i>

</a>

<a href="approve_loan.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">

<i class="bi bi-check-circle"></i>

</a>

<a href="reject_loan.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm">

<i class="bi bi-x-circle"></i>

</a>


<a href="loan_details.php?id=<?php echo $row['id']; ?>"
class="btn btn-info btn-sm">

<i class="bi bi-file-earmark-text"></i>

</a>


<a href="delete_loan.php?id=<?php echo $row['id']; ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Delete Loan?')">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="6" class="text-center">

No Loans Found

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

<?php include "../includes/footer.php"; ?>