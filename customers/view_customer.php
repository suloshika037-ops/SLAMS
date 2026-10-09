<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

$id=intval($_GET['id']);

$stmt=$conn->prepare("SELECT customers.*,users.name,users.email FROM customers
INNER JOIN users ON customers.user_id=users.id WHERE customers.id=?");

$stmt->bind_param("i",$id);
$stmt->execute();
$result=$stmt->get_result();
if($result->num_rows==0){
die("Customer Not Found");
}

$row=$result->fetch_assoc();

?>

<div class="content">
<div class="card p-4">
<h2 class="mb-4">Customer Details</h2>

<table class="table table-bordered">
<tr>
<th width="200">Customer Name</th>
<td><?= $row['name']; ?></td>
</tr>

<tr>
<th>Email</th>
<td><?= $row['email']; ?></td>
</tr>

<tr>
<th>Phone</th>
<td><?= $row['phone']; ?></td>
</tr>

<tr>
<th>NIC</th>
<td><?= $row['nic']; ?></td>
</tr>

<tr>
<th>Address</th>
<td><?= $row['address']; ?></td>
</tr>

</table>

<a href="customer_list.php" class="btn btn-primary">Back</a>

</div>
</div>

<?php
include "../includes/footer.php";
?>