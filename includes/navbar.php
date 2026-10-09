<nav class="top-navbar">

<div class="brand">
    <i class="bi bi-bank2"></i>
    <span>
        SLAMS
        <small>Smart Loan Analytics Management System</small>
    </span>
</div>


<div class="user-area">

<?php if(isset($_SESSION['name'])) { ?>

<i class="bi bi-person-circle"></i>

<span>
<?php echo $_SESSION['name']; ?>
</span>

<a href="/slams/register.php" class="btn btn-success me-2">
Registration
</a>



<a href="/slams/logout.php" class="logout-btn">
<i class="bi bi-box-arrow-right"></i>
Logout
</a>

<?php } ?>

</div>

</nav>