<?php
include "../config/auth.php";
include "../includes/auth_check.php";

if(!isset($_GET['id'])){
    die("Customer ID Missing");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM customers WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows==0){
    die("Customer Not Found");
}

$row = $result->fetch_assoc();

if(isset($_POST['update'])){

    $phone = trim($_POST['phone']);
    $nic = trim($_POST['nic']);
    $address = trim($_POST['address']);

    $update = $conn->prepare("UPDATE customers SET phone=?, nic=?, address=? WHERE id=?");
    $update->bind_param("sssi",$phone,$nic,$address,$id);

    if($update->execute()){
        
        header("Location: customer_list.php?updated=1");
        exit();
    }else{
        $error="Update Failed";
    }

}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";
?>

<div class="content">
<div class="card shadow-lg border-0 p-4">

<h2 class="mb-4"><i class="bi bi-pencil-square text-warning"></i>Edit Customer</h2>

<?php
if(isset($error)){
?>
<div class="alert alert-danger">
<?= $error ?>
</div>
<?php
}
?>

<form method="POST">

<div class="mb-3">
<label class="form-label">Phone Number</label>
<input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($row['phone']) ?>" required>
</div>

<div class="mb-3">
<label class="form-label">NIC</label>
<input type="text" name="nic" class="form-control" value="<?= htmlspecialchars($row['nic']) ?>" required>
</div>

<div class="mb-3">
<label class="form-label">Address</label>
<textarea name="address" class="form-control" rows="4" required><?= htmlspecialchars($row['address']) ?></textarea>
</div>

<button class="btn btn-warning" name="update"><i class="bi bi-check-circle"></i>Update Customer</button>

<a href="customer_list.php" class="btn btn-secondary">Cancel</a>

</form>

</div>
</div>

<?php
include "../includes/footer.php";
?>