<?php

include "config/db.php";

if(isset($_POST['register'])){

$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];
$role="Customer";

$check=$conn->prepare("SELECT id FROM users WHERE email=?");

$check->bind_param("s",$email);
$check->execute();
$result=$check->get_result();

if($result->num_rows>0){

$error="Email already exists";}

else{
$hash=password_hash($password,PASSWORD_DEFAULT);

$stmt=$conn->prepare("INSERT INTO users(name,email,password,role)VALUES(?,?,?,?)");

$stmt->bind_param("ssss",$name,$email,$hash,$role);

if($stmt->execute()){
header("Location:customers/customer_list.php?success=User Register Successfully ");
exit();
}
else{
$error="Registration Failed";
}}}
?>


<!DOCTYPE html>
<html>
<head><title>SLAMS Register</title>
<link rel="stylesheet" href="assets/css/style.css"></head>
<body>

<div class="auth-container">
<div class="auth-image">
<img src="assets/images/login.jpg">
</div>

<div class="auth-box">
<img src="assets/images/logo.png" class="logo">
<h2>Create Account</h2>

<?php
if(isset($error)){
echo "<p class='error'>$error</p>";}
?>

<form method="POST">

<input type="text"
name="name"
placeholder="Full Name"
required>

<input type="email"
name="email"
placeholder="Email"
required>

<input type="password"
name="password"
placeholder="Password"
required>

<button name="register">
Register
</button>

</form>

<p>

Already have account?

<a href="login.php">
Login
</a>

</p>

</div>
</div>

</body>
</html>