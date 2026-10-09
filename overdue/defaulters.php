<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";



$sql = "

SELECT

users.name,

users.email,

COUNT(installments.id) AS unpaid_count,

SUM(installments.amount) AS total_due


FROM installments


INNER JOIN loans

ON installments.loan_id = loans.id


INNER JOIN customers

ON loans.customer_id = customers.id


INNER JOIN users

ON customers.user_id = users.id



WHERE installments.status='Unpaid'


GROUP BY customers.id


HAVING unpaid_count >= 2


ORDER BY unpaid_count DESC

";



$result = $conn->query($sql);


?>


<div class="content">


<div class="card shadow p-4">


<h3 class="mb-4">

Defaulters List

</h3>



<table class="table table-bordered table-hover">


<thead>


<tr>

<th>Customer Name</th>

<th>Email</th>

<th>Pending Installments</th>

<th>Total Due Amount</th>

</tr>


</thead>


<tbody>



<?php


if($result && $result->num_rows > 0){


while($row=$result->fetch_assoc()){


?>


<tr>


<td>

<?= $row['name']; ?>

</td>


<td>

<?= $row['email']; ?>

</td>


<td>

<span class="badge bg-danger">

<?= $row['unpaid_count']; ?>

</span>

</td>


<td>

Rs. <?= number_format($row['total_due'],2); ?>

</td>


</tr>


<?php


}


}

else{


?>


<tr>

<td colspan="4" class="text-center">

No Defaulters Found

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