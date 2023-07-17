<?php
    require_once 'common.php';
    
    # Clear $_SESSION upon being directed here
    if (isset($_SESSION['accID'])){
        $_SESSION = [];
    }
    header("Location: login.php");
    exit;
?>