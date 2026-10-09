<?php

include "../config/auth.php";
include "../includes/auth_check.php";

$id = $_GET['id'];

$sql = "SELECT
        payments.*,
        installments.installment_no,
        installments.loan_id,
        loans.customer_id,
        users.name,
        users.email
        FROM payments

        INNER JOIN installments
        ON payments.installment_id = installments.id

        INNER JOIN loans
        ON installments.loan_id = loans.id

        INNER JOIN customers
        ON loans.customer_id = customers.id

        INNER JOIN users
        ON customers.user_id = users.id

        WHERE payments.id='$id'";


$result = $conn->query($sql);


if($result->num_rows == 0){

echo "Receipt Not Found";
exit();

}


$row = $result->fetch_assoc();

?>


<!DOCTYPE html>
<html>

<head>

<title>Payment Receipt</title>


<style>

body{

font-family: Arial;
background:#f5f5f5;

}


.receipt{

width:600px;
margin:40px auto;
background:white;
padding:30px;
border-radius:10px;

}


h2{

text-align:center;
color:#4b0082;

}


table{

width:100%;
border-collapse:collapse;

}


td{

padding:10px;
border-bottom:1px solid #ddd;

}


.print{

margin-top:20px;
text-align:center;

}


button{

background:#4b0082;
color:white;
padding:10px 20px;
border:none;
cursor:pointer;

}


</style>


</head>


<body>


<div class="receipt">


<h2>
SLAMS
</h2>

<h3 style="text-align:center;">
Payment Receipt
</h3>


<table>


<tr>
<td>Receipt Number</td>
<td>
<?= $row['receipt_no']; ?>
</td>
</tr>


<tr>
<td>Customer Name</td>
<td>
<?= $row['name']; ?>
</td>
</tr>


<tr>
<td>Email</td>
<td>
<?= $row['email']; ?>
</td>
</tr>


<tr>
<td>Loan ID</td>
<td>
<?= $row['loan_id']; ?>
</td>
</tr>


<tr>
<td>Installment No</td>
<td>
<?= $row['installment_no']; ?>
</td>
</tr>


<tr>
<td>Payment Amount</td>
<td>
Rs. <?= number_format($row['amount'],2); ?>
</td>
</tr>


<tr>
<td>Paid Date</td>
<td>
<?= $row['paid_date']; ?>
</td>
</tr>


</table>



<div class="print">

<button onclick="window.print()">

Print Receipt

</button>


</div>



</div>


</body>

</html>