<?php
    require_once("common.php");
    $last_value = $_POST['inout'];
    $check_place = $_POST['places'];
    $id = $_SESSION['accID'];

    $LOC_dao = new HistoryDAO();
    if($last_value == 0){
        $success = $LOC_dao->add($check_place, $id, 1, 0);
        if($success){
            echo "<h1>Successful check in!</h1></br>";
            echo "Click <a href='User_history.php'>here</a> to view user history";
        }
        else{
            echo "Check in unsuccessful";
            echo "Click <a href='User_history.php'>here</a> to view user history";
        }

    }
    elseif($last_value == 1){
        $success = $LOC_dao->add($check_place, $id, 0, 1);
        if($success){
            echo "<h1>Successful check out!</h1></br>";
            echo "Click <a href='User_history.php'>here</a> to view user history";
        }
        else{
            echo "Check out unsuccessful";
            echo "Click <a href='User_history.php'>here</a> to view user history";
        }
    }
?>