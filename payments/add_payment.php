<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";


if(isset($_POST['pay'])){

    $installment_id = $_POST['installment_id'];
    $amount = $_POST['amount'];
    $paid_date = $_POST['paid_date'];

    // Generate Receipt Number
    $receipt_no = "RCPT".date("YmdHis");

    // Get Installment Details
    $stmt = $conn->prepare("SELECT * FROM installments WHERE id=?");
    $stmt->bind_param("i",$installment_id);
    $stmt->execute();
    $installment = $stmt->get_result()->fetch_assoc();

    if($installment){

        // Insert Payment
        $insert = $conn->prepare("INSERT INTO payments(receipt_no,installment_id,paid_date,amount)
        VALUES(?,?,?,?)");

        $insert->bind_param(
            "sssd",
            $receipt_no,
            $installment_id,
            $paid_date,
            $amount
        );

        if($insert->execute()){

            // Update Installment Status
            $update = $conn->prepare("UPDATE installments SET status='Paid' WHERE id=?");
            $update->bind_param("i",$installment_id);
            $update->execute();

            // Get Loan ID
            $loan_id = $installment['loan_id'];

            // Reduce Outstanding Balance
            $loan = $conn->query("SELECT outstanding_balance FROM loans WHERE id='$loan_id'")->fetch_assoc();

            $new_balance = $loan['outstanding_balance'] - $amount;

            if($new_balance < 0){
                $new_balance = 0;
            }

            $balance = $conn->prepare("UPDATE loans SET outstanding_balance=? WHERE id=?");
            $balance->bind_param("di",$new_balance,$loan_id);
            $balance->execute();

            if($stmt->execute()){

header("Location: payment_history.php");
exit();

}else{

$message="Failed to save.";

}}}}

?>

<div class="content">

<div class="card shadow p-4">

<h3 class="mb-4">

Record Payment

</h3>

<form method="POST">

<div class="mb-3">

<label>Installment</label>

<select name="installment_id" class="form-control" required>

<option value="">Select Installment</option>

<?php

$result = $conn->query("SELECT * FROM installments WHERE status='Unpaid'");

while($row = $result->fetch_assoc()){

?>

<option value="<?= $row['id']; ?>">

Installment #<?= $row['installment_no']; ?>

| Loan <?= $row['loan_id']; ?>

| Rs.<?= number_format($row['amount'],2); ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Payment Amount</label>

<input
type="number"
step="0.01"
name="amount"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Paid Date</label>

<input
type="date"
name="paid_date"
class="form-control"
value="<?= date('Y-m-d'); ?>"
required>

</div>

<button class="btn btn-success" name="pay">

Record Payment

</button>

<a href="payment_history.php" class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

<?php

include "../includes/footer.php";

?>