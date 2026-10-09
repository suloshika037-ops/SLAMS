<?php
include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

if(isset($_POST['generate'])){
    $loan_id = $_POST['loan_id'];
    $months = $_POST['months'];
    $start_date = $_POST['start_date'];

$stmt = $conn->prepare("SELECT total_repayable FROM loans WHERE id=?");

$stmt->bind_param("i",$loan_id);

$stmt->execute();

$result=$stmt->get_result();

$loan=$result->fetch_assoc();

$total = $loan['total_repayable'];

$installment_amount = $total / $months;

for($i=1;$i<=$months;$i++){
    $due_date = date('Y-m-d',strtotime("+$i month",strtotime($start_date)));
    
    $insert=$conn->prepare("INSERT INTO installments(installment_no,loan_id,due_date,amount,status)VALUES(?,?,?,?,?)");
    
    $status="Unpaid";
    
    $insert->bind_param("iisds",$i,$loan_id,$due_date,$installment_amount,$status);

    $insert->execute();
}



echo "
<script>alert('Installments Generated Successfully');
window.location='installment_list.php';
</script>";
}
?>

<div class="content">
<div class="card shadow p-4">
<h3 class="mb-4">Generate Installment Schedule</h3>

<form method="POST">

<div class="mb-3">

<label>Select Loan</label>
<select name="loan_id" class="form-control" required>

<option value="">Select Loan</option>

<?php
$result=$conn->query("SELECT loans.id,users.name,loans.amount FROM loans

INNER JOIN customers ON loans.customer_id=customers.id

INNER JOIN users ON customers.user_id=users.id

WHERE loans.status='Approved'");

while($row=$result->fetch_assoc()){
?>

<option value="<?= $row['id']; ?>">
Loan #<?= $row['id']; ?>
-
<?= $row['name']; ?>
(Rs.<?= $row['amount']; ?>)
</option>

<?php
}
?>

</select>
</div>

<div class="mb-3"><label>Number of Months</label>
<input type="number" name="months" class="form-control" required>
</div>

<div class="mb-3">
<label>First Payment Date</label>
<input type="date" name="start_date" class="form-control" required>
</div>

<button class="btn btn-primary" name="generate">Generate Schedule</button>

</form>
</div>
</div>

<?php
include "../includes/footer.php";
?>