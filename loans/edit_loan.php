<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";


if(!isset($_GET['id'])){

echo "<div class='alert alert-danger'>Loan ID Missing</div>";
exit();

}


$id = $_GET['id'];


// Get loan details

$stmt = $conn->prepare("SELECT * FROM loans WHERE id=?");

$stmt->bind_param("i",$id);

$stmt->execute();

$result = $stmt->get_result();


if($result->num_rows == 0){

echo "<div class='alert alert-danger'>Loan Not Found</div>";
exit();

}


$loan = $result->fetch_assoc();



if(isset($_POST['update'])){


$amount = $_POST['amount'];

$interest_rate = $_POST['interest_rate'];

$total_repayable = $_POST['total_repayable'];

$outstanding_balance = $_POST['outstanding_balance'];

$status = $_POST['status'];



$update = $conn->prepare("

UPDATE loans SET

amount=?,
interest_rate=?,
total_repayable=?,
outstanding_balance=?,
status=?

WHERE id=?

");


$update->bind_param(

"ddddsi",

$amount,
$interest_rate,
$total_repayable,
$outstanding_balance,
$status,
$id

);



if($update->execute()){
        
        header("Location: loan_list.php?updated=1");
        exit();
    }else{
        $error="Update Failed";
    }



}


?>


<div class="content">

<div class="card shadow p-4">


<h3 class="mb-4">

Edit Loan

</h3>


<form method="POST">


<div class="mb-3">

<label>Loan Amount</label>

<input
type="number"
step="0.01"
id="amount"
name="amount"
class="form-control"
value="<?= $loan['amount']; ?>"
onkeyup="calculateLoan()"
required>

</div>



<div class="mb-3">

<label>Interest Rate (%)</label>

<input
type="number"
step="0.01"
id="interest_rate"
name="interest_rate"
class="form-control"
value="<?= $loan['interest_rate']; ?>"
onkeyup="calculateLoan()"
required>

</div>



<div class="mb-3">

<label>Total Repayable</label>

<input
type="number"
step="0.01"
id="total_repayable"
name="total_repayable"
class="form-control"
value="<?= $loan['total_repayable']; ?>"
readonly>

</div>



<div class="mb-3">

<label>Outstanding Balance</label>

<input
type="number"
step="0.01"
id="outstanding_balance"
name="outstanding_balance"
class="form-control"
value="<?= $loan['outstanding_balance']; ?>"
readonly>

</div>



<div class="mb-3">

<label>Status</label>

<select name="status" class="form-control">


<option value="Pending"
<?= ($loan['status']=="Pending")?'selected':''; ?>>

Pending

</option>


<option value="Approved"
<?= ($loan['status']=="Approved")?'selected':''; ?>>

Approved

</option>


<option value="Rejected"
<?= ($loan['status']=="Rejected")?'selected':''; ?>>

Rejected

</option>


</select>

</div>



<button class="btn btn-warning" name="update">

Update Loan

</button>


<a href="loan_list.php" class="btn btn-secondary">

Cancel

</a>


</form>


</div>

</div>



<script>

function calculateLoan(){


let amount = parseFloat(document.getElementById("amount").value) || 0;


let interest = parseFloat(document.getElementById("interest_rate").value) || 0;



let interestAmount = (amount * interest) / 100;


let total = amount + interestAmount;



document.getElementById("total_repayable").value = total.toFixed(2);


document.getElementById("outstanding_balance").value = total.toFixed(2);



}


// Load calculation when page opens

calculateLoan();


</script>



<?php

include "../includes/footer.php";

?>