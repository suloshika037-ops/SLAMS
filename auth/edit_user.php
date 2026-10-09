<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";
include "../includes/audit_function.php";

if(!isset($_GET['id'])){
    addAuditLog($conn, "Updated User");
    header("Location: ../admin/user_management.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows==0){
    echo "<div class='alert alert-danger'>User Not Found</div>";
    include "../includes/footer.php";
    exit();
}

$row = $result->fetch_assoc();

if(isset($_POST['update'])){

$name=$_POST['name'];
$email=$_POST['email'];
$role=$_POST['role'];

$update=$conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
$update->bind_param("sssi",$name,$email,$role,$id);

if($update->execute()){

header("Location: ../admin/user_management.php");
exit();

}else{

echo "<div class='alert alert-danger'>Update Failed</div>";

}

}

?>

<div class="content">

<div class="container-fluid">

<div class="card shadow p-4">

<h2>Edit User</h2>

<form method="POST">

<div class="mb-3">

<label>Name</label>

<input type="text"
name="name"
class="form-control"
value="<?= $row['name']; ?>"
required>

</div>

<div class="mb-3">

<label>Email</label>

<input type="email"
name="email"
class="form-control"
value="<?= $row['email']; ?>"
required>

</div>

<div class="mb-3">

<label>Role</label>

<select
name="role"
class="form-control">

<option value="Admin"
<?=($row['role']=="Admin")?"selected":"";?>>

Admin

</option>

<option value="Customer"
<?=($row['role']=="Customer")?"selected":"";?>>

Customer

</option>

</select>

</div>

<button
class="btn btn-warning"
name="update">

Update User

</button>

<a href="../admin/user_management.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

<?php

include "../includes/footer.php";

?>
