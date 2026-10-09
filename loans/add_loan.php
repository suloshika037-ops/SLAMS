<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";


if(isset($_POST['save'])){

$customer=$_POST['customer_id'];
$amount=$_POST['amount'];
$interest=$_POST['interest_rate'];
$status=$_POST['status'];
$created_at=$_POST['created_at'];

$stmt=$conn->prepare("INSERT INTO loans(customer_id,amount,interest_rate,status,created_at) VALUES(?,?,?,?,?)");

$stmt->bind_param("iddss",$customer,$amount,$interest,$status,$created_at);

if($stmt->execute()){
    header("Location: loan_list.php"); 
    exit();}
else{
    $message="Failed to save.";}
}
?>

<div class="content">
<div class="card p-4">

<h3>Add Loan</h3>

<form method="POST">
<div class="mb-3">
<label>Customer</label>
<select name="customer_id" class="form-control" required>
<option value="">Select Customer</option>

<?php
$result=$conn->query("SELECT customers.id,users.name FROM customers
INNER JOIN users ON customers.user_id=users.id");
while($row=$result->fetch_assoc()){
?>

<option value="<?= $row['id']; ?>">
<?= $row['name']; ?>
</option>

<?php } ?>

</select>
</div>

<div class="mb-3">
<label>Loan Amount</label>
<input type="number" step="0.01" name="amount" class="form-control" required>
</div>

<div class="mb-3">
<label>Interest Rate</label>
<input type="number" step="0.01" name="interest_rate" class="form-control" required>
</div>

<div class="mb-3">
<label>Status</label>
<select name="status" class="form-control">
<option value="Pending">Pending</option>
<option value="Approved">Approved</option>
<option value="Rejected">Rejected</option>
</select>
</div>

<div class="mb-3">
<label>Loan Date</label>
<input type="date" name="created_at " class="form-control" required>
</div>

<button type="submit" name="save" class="btn btn-primary">Save Loan</button>

<a href="loan_list.php" class="btn btn-secondary">Cancel</a>

</form>
</div>
</div>

<?php include "../includes/footer.php"; ?>