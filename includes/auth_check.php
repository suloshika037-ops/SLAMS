<?php

if(session_status() == PHP_SESSION_NONE){

    session_start();

}


if(!isset($_SESSION['user_id'])){

    echo "<script>
    alert('Please Login First');
    window.location='../login.php';
    </script>";

    exit();

}

?>