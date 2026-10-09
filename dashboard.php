<?php

include "config/auth.php";
include "includes/auth_check.php";

include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

// Total Customers

$customers = $conn->query(
"SELECT COUNT(*) AS total FROM customers"
)->fetch_assoc();

// Total Loans

$loans = $conn->query(
"SELECT COUNT(*) AS total FROM loans"
)->fetch_assoc();

// Active Loans

$active = $conn->query(
"SELECT COUNT(*) AS total FROM loans WHERE status='Approved'"
)->fetch_assoc();

// Pending Loans

$pending = $conn->query(
"SELECT COUNT(*) AS total FROM loans WHERE status='Pending'"
)->fetch_assoc();

$overdue = $conn->query(
"SELECT COUNT(*) AS total
FROM installments
WHERE status='Unpaid'
AND due_date < CURDATE()"

)->fetch_assoc();
$payments = $conn->query(
"SELECT SUM(amount) AS total
FROM payments"

)->fetch_assoc();
$statusData = $conn->query(
"SELECT status, COUNT(*) AS total
FROM loans
GROUP BY status");

$statusLabels=[];
$statusValues=[];

while($row=$statusData->fetch_assoc()){
$statusLabels[]=$row['status'];
$statusValues[]=$row['total'];
}

$monthly = $conn->query("
SELECT
MONTH(paid_date) AS month,
SUM(amount) AS total
FROM payments
GROUP BY MONTH(paid_date)
ORDER BY month");

$monthLabels=[];
$monthValues=[];

while($row=$monthly->fetch_assoc()){
$monthLabels[]=$row['month'];
$monthValues[]=$row['total'];
}
?>

<div class="content">
<div class="container-fluid">

<h2 class="mb-4">
Admin Dashboard
</h2>

<div class="row">
<div class="col-md-4 mb-3">
<div class="card bg-primary text-white p-3">

<h5>Total Customers</h5>

<h2>
<?= $customers['total']; ?>
</h2>

</div>
</div>

<div class="col-md-4 mb-3">
<div class="card bg-purple text-dark p-3">

<h5>Total Loans</h5>

<h2>
<?= $loans['total']; ?>
</h2>

</div>
</div>

<div class="col-md-4 mb-3">
<div class="card bg-success text-white p-3">

<h5>Active Loans</h5>

<h2>
<?= $active['total']; ?>
</h2>

</div>
</div>

<div class="col-md-4 mb-3">
<div class="card bg-warning p-3">

<h5>Pending Loans</h5>

<h2>
<?= $pending['total']; ?>
</h2>

</div>
</div>

<div class="col-md-4 mb-3">
<div class="card bg-danger text-white p-3">

<h5>Overdue Loans</h5>

<h2>
<?= $overdue['total']; ?>
</h2>

</div>
</div>

<div class="col-md-4 mb-3">
<div class="card bg-dark text-white p-3">

<h5>Total Payments</h5>

<h2>
Rs.
<?= number_format($payments['total'] ?? 0,2); ?>
</h2>

</div>
</div>
</div>

<!-- Charts -->
<div class="row mt-4">
<div class="col-md-6">
<div class="card p-3">

<h4>
Loan Status
</h4>

<canvas id="loanChart"></canvas>

</div>
</div>

<div class="col-md-6">
<div class="card p-3">

<h4>
Monthly Collection
</h4>

<canvas id="paymentChart"></canvas>

</div>
</div>
</div>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(
document.getElementById('loanChart'),
{

type:'doughnut',

data:{

labels:
<?= json_encode($statusLabels); ?>,

datasets:[{

data:
<?= json_encode($statusValues); ?>,

backgroundColor:[
'#0c8808',
'#ece91e',
'#e40d0d'
],

borderColor:'#ffffff',

borderWidth:3,

hoverOffset:10

}]

},

options:{

responsive:true,

plugins:{

legend:{

position:'bottom',

labels:{

font:{

size:14

}

}

}

}

}

});

new Chart(document.getElementById('paymentChart'),{

type:'bar',

data:{
labels:<?= json_encode($monthLabels); ?>,

datasets:[{
label:'Monthly Collection',
data:<?= json_encode($monthValues); ?>,
backgroundColor:'#6C63FF',
borderColor:'#4B3DBD',
borderWidth:2,
borderRadius:10,
borderSkipped:false,
hoverBackgroundColor:'#4B3DBD'
}]
},

options:{
responsive:true,

plugins:{
legend:{
display:false
}
},

scales:{
y:{
beginAtZero:true,
grid:{
color:'#EAEAEA'
}
},

x:{
grid:{
display:false
}
}
}
}

});
</script>

<?php
include "includes/footer.php";
?>