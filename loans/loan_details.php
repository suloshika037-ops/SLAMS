<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";


if(!isset($_GET['id'])){

echo "<div class='alert alert-danger'>Loan ID Missing</div>";
exit();

}


$id = $_GET['id'];


$sql = "SELECT loans.*,
users.name,
users.email

FROM loans

INNER JOIN customers
ON loans.customer_id = customers.id

INNER JOIN users
ON customers.user_id = users.id

WHERE loans.id=?";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i",$id);

$stmt->execute();

$result = $stmt->get_result();


if($result->num_rows == 0){

echo "<div class='alert alert-danger'>Loan Not Found</div>";
exit();

}


$loan = $result->fetch_assoc();

?>


<div class="content">

<div class="card shadow p-4">


<h3 class="mb-4">
Loan Details
</h3>


<table class="table table-bordered">


<tr>

<th>Loan ID</th>

<td>
<?= $loan['id']; ?>
</td>

</tr>


<tr>

<th>Customer Name</th>

<td>
<?= $loan['name']; ?>
</td>

</tr>


<tr>

<th>Email</th>

<td>
<?= $loan['email']; ?>
</td>

</tr>


<tr>

<th>Loan Amount</th>

<td>
Rs. <?= number_format($loan['amount'],2); ?>
</td>

</tr>


<tr>

<th>Interest Rate</th>

<td>
<?= $loan['interest_rate']; ?> %
</td>

</tr>


<tr>

<th>Total Repayable</th>

<td>
Rs. <?= number_format($loan['total_repayable'],2); ?>
</td>

</tr>


<tr>

<th>Outstanding Balance</th>

<td>
Rs. <?= number_format($loan['outstanding_balance'],2); ?>
</td>

</tr>


<tr>

<th>Status</th>

<td>

<?php

if($loan['status']=="Approved"){

echo "<span class='badge bg-success'>Approved</span>";

}
elseif($loan['status']=="Rejected"){

echo "<span class='badge bg-danger'>Rejected</span>";

}
else{

echo "<span class='badge bg-warning text-dark'>Pending</span>";

}

?>

</td>

</tr>


<tr>

<th>Created Date</th>

<td>
<?= $loan['created_at']; ?>
</td>

</tr>


</table>

<br>


<div class="card shadow p-4 mt-4">


<h4 class="mb-3">

Repayment Schedule

</h4>


<table class="table table-bordered table-hover">


<thead>

<tr>

<th>No</th>

<th>Due Date</th>

<th>Amount</th>

<th>Status</th>

</tr>

</thead>


<tbody>


<?php


$installments = $conn->query("

SELECT *

FROM installments

WHERE loan_id='$id'

ORDER BY installment_no ASC

");



if($installments && $installments->num_rows > 0){


while($row = $installments->fetch_assoc()){


?>


<tr>


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


<?php


if($row['status']=="Paid"){


echo "

<span class='badge bg-success'>

Paid

</span>

";


}

else{


echo "

<span class='badge bg-danger'>

Unpaid

</span>

";


}


?>


</td>


</tr>


<?php


}


}

else{


?>


<tr>

<td colspan="4" class="text-center">

No Installment Schedule Generated

</td>

</tr>


<?php

}


?>


</tbody>


</table>


</div>

<a href="edit_loan.php?id=<?php echo $loan['id']; ?>"
class="btn btn-warning">

Edit Loan

</a>


<a href="loan_list.php"
class="btn btn-secondary">

Back

</a>


</div>

</div>


<?php

include "../includes/footer.php";

?>