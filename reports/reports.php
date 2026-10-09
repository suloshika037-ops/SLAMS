<?php

include "../config/auth.php";
include "../includes/auth_check.php";
include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>

<div class="content">

<div class="container-fluid">

<h2 class="mb-4">Report Generation</h2>

<div class="row">

<div class="col-md-6 mb-4">

<div class="card shadow p-4 text-center">

<h4>Monthly Report</h4>

<p>View monthly loan and payment summary.</p>

<a href="monthly_report.php" class="btn btn-primary">

<i class="bi bi-calendar-month"></i>

Open Monthly Report

</a>

</div>

</div>

<div class="col-md-6 mb-4">

<div class="card shadow p-4 text-center">

<h4>Yearly Report</h4>

<p>View yearly loan and payment summary.</p>

<a href="yearly_report.php" class="btn btn-success">

<i class="bi bi-calendar3"></i>

Open Yearly Report

</a>

</div>

</div>

</div>

</div>

</div>

<?php

include "../includes/footer.php";

?>