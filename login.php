<?php

session_start();

include "config/db.php";

if(isset($_POST['login'])){
$email=$_POST['email'];
$password=$_POST['password'];
$stmt=$conn->prepare(
"SELECT * FROM users WHERE email=?"
);

$stmt->bind_param("s",$email);

$stmt->execute();
$result=$stmt->get_result();

if($result->num_rows > 0){
$user=$result->fetch_assoc();

if(password_verify($password,$user['password'])){

$_SESSION['user_id']=$user['id'];
$_SESSION['name']=$user['name'];
$_SESSION['role']=$user['role'];

header("Location: dashboard.php");
exit();}

else{
$error="Invalid Password";
}}
else{
$error="Email not found";
}}
?>

<!DOCTYPE html>
<html>
<head><title>SLAMS Login</title>
<link rel="stylesheet" href="assets/css/style.css"></head>

<body>

<div class="auth-container">

<!-- LEFT IMAGE -->

<div class="auth-image">
<img src="assets/images/login.jpg">
</div>

<!-- RIGHT FORM -->

<div class="auth-box">
<img src="assets/images/logo.png" class="logo">

<h2>SLAMS Login</h2>

<?php
if(isset($error)){
echo "<p class='error'>$error</p>";
}
?>

<form method="POST">

<input type="email"
name="email"
placeholder="Email"
required>

<input type="password"
name="password"
placeholder="Password"
required>

<button name="login">
Login
</button>

</form>

<p>
Don't have an account?

<a href="register.php">
Register
</a>
</p>

</div>
</div>

</body>
</html>