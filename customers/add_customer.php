<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

$message="";

if(isset($_POST['save'])){
    $user_id=$_POST['user_id'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $nic=$_POST['nic'];

$check=$conn->prepare("SELECT * FROM customers WHERE user_id=?");
$check->bind_param("i",$user_id);
$check->execute();

if($check->get_result()->num_rows>0){
    $message="Customer already exists.";}

    else{

$stmt=$conn->prepare("INSERT INTO customers(user_id,phone,address,nic) VALUES(?,?,?,?)");

$stmt->bind_param("isss",$user_id,$phone,$address,$nic);

if($stmt->execute()){
    header("Location: customer_list.php");
    exit();}

    else{
        $message="Failed to save.";}
}}

?>

<div class="content">
<div class="card p-4">
<h3>Add Customer</h3>

<?php

if($message!=""){
    echo "<div class='alert alert-danger'>$message</div>";}

?>

<form method="POST">

<div class="mb-3">

<label>User</label>

<select name="user_id" class="form-control" required>

<option value="">Select User</option>

<?php

$users=$conn->query("SELECT * FROM users WHERE role='customer'");

while($u=$users->fetch_assoc()){
?>

<option value="<?= $u['id']; ?>"><?= $u['name']; ?> (<?= $u['email']; ?>)</option>

<?php
}
?>

</select>
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="phone" class="form-control" required>
</div>

<div class="mb-3">
<label>NIC</label>
<input type="text" name="nic" class="form-control" required>
</div>

<div class="mb-3">
<label>Address</label>
<textarea name="address" class="form-control" rows="4" required></textarea>
</div>

<button class="btn btn-primary" name="save">Save Customer</button>

<a href="customer_list.php" class="btn btn-secondary">Back</a>

</form>

</div>
</div>

<?php

include "../includes/footer.php";

?>