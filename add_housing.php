<?php
require_once('common.php');
if( ($_POST['area']) != '' && ($_POST['address']) != ''){
    $id = $_SESSION['accID'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $trim_area = trim($area);
    $trim_add = trim($address);

    $HOUS_dao = new HousingDAO();
    $success = $HOUS_dao->add($id, $trim_area, $trim_add);
    var_dump($success);
    if($success){
        header("Location: User_location.php");
        exit;
    }
    else{
        echo "There seems to be an error adding housing.";
        echo "</br>Click <a href='User_history.php'>here</a> to go back";
        echo "</br></br><a href='User_location.php'>Check</a> whether housing 
                already exists.";

    }
}
else{
    echo "Please fill in BOTH area and address.";
    echo "</br>Click <a href='User_history.php'>here</a> to go back";
}
?>