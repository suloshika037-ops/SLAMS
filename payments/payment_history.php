<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

$sql = "

SELECT

payments.*,

installments.loan_id,

installments.installment_no

FROM payments

INNER JOIN installments

ON payments.installment_id=installments.id

ORDER BY payments.id DESC

";

$result = $conn->query($sql);

?>

<div class="content">

<div class="card shadow p-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h3>Payment History</h3>

<a href="add_payment.php" class="btn btn-success">

<i class="bi bi-cash-coin"></i>

Record Payment

</a>

</div>

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>ID</th>

<th>Receipt No</th>

<th>Loan ID</th>

<th>Installment</th>

<th>Paid Date</th>

<th>Amount</th>

<th width="120">Action</th>

</tr>

</thead>

<tbody>

<?php

if($result && $result->num_rows>0){

while($row=$result->fetch_assoc()){

?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['receipt_no']; ?></td>

<td><?= $row['loan_id']; ?></td>

<td><?= $row['installment_no']; ?></td>

<td><?= $row['paid_date']; ?></td>

<td>

Rs. <?= number_format($row['amount'],2); ?>

</td>

<td>

<a href="receipt.php?id=<?php echo $row['id']; ?>"

class="btn btn-primary btn-sm">

<i class="bi bi-receipt"></i>

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="7" class="text-center">

No Payments Found

</td>

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

?>s