<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";


$sql = "

SELECT

installments.*,

loans.customer_id,

users.name


FROM installments


INNER JOIN loans

ON installments.loan_id = loans.id


INNER JOIN customers

ON loans.customer_id = customers.id


INNER JOIN users

ON customers.user_id = users.id


WHERE installments.status='Unpaid'

AND installments.due_date < CURDATE()


ORDER BY installments.due_date ASC

";


$result = $conn->query($sql);


?>


<div class="content">


<div class="card shadow p-4">


<div class="d-flex justify-content-between align-items-center mb-4">


<h3>

Overdue Loans

</h3>


<a href="defaulters.php" class="btn btn-danger">

<i class="bi bi-person-x"></i>

View Defaulters

</a>


</div>



<table class="table table-bordered table-hover">


<thead>

<tr>

<th>Loan ID</th>

<th>Customer</th>

<th>Installment No</th>

<th>Due Date</th>

<th>Amount</th>

<th>Days Overdue</th>

</tr>

</thead>



<tbody>


<?php


if($result && $result->num_rows > 0){


while($row=$result->fetch_assoc()){


$days = floor(
(strtotime(date('Y-m-d')) - strtotime($row['due_date']))
/ (60*60*24)
);


?>


<tr>


<td>

<?= $row['loan_id']; ?>

</td>


<td>

<?= $row['name']; ?>

</td>


<td>

<?= $row['installment_no']; ?>

</td>


<td>

<?= $row['due_date']; ?>

</td>


<td>

Rs. <?= number_format($row['amount'],2); ?>

</td>


<td>

<span class="badge bg-danger">

<?= $days; ?> Days

</span>

</td>


</tr>


<?php


}


}

else{


?>


<tr>

<td colspan="6" class="text-center">

No Overdue Loans Found

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

?>

