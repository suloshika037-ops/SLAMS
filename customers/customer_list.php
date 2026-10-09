<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

$sql = "SELECT customers.*, users.name, users.email FROM customers
        INNER JOIN users ON customers.user_id = users.id
        ORDER BY customers.id DESC";

$result = $conn->query($sql);

?>

<div class="content">
<div class="card p-4">
<div class="d-flex justify-content-between align-items-center mb-4">

<h3>Customer Management</h3>

<a href="add_customer.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i>Add Customer</a>

</div>

<table class="table table-bordered table-hover">

<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>NIC</th>
<th>Status</th>
<th width="220">Action</th>
</tr>
</thead>
<tbody>

<?php
if($result->num_rows>0){while($row=$result->fetch_assoc()){
?>

<tr>
<td><?= $row['id']; ?></td>
<td><?= $row['name']; ?></td>
<td><?= $row['email']; ?></td>
<td><?= $row['phone']; ?></td>
<td><?= $row['nic']; ?></td>
<td>
<span class="badge bg-success">Registered</span>
</td>

<td>
<a href="view_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
    <i class="bi bi-eye"></i></a>

<a href="edit_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
    <i class="bi bi-pencil-square"></i></a>

<a href="delete_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this customer?')">
    <i class="bi bi-trash"></i></a>
</td>
</tr>

<?php
}}else{
?>

<tr>
<td colspan="7" class="text-center">No Customers Found</td>
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