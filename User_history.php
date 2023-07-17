<?php

require_once 'common.php';

function CreateTableforUser($ID){
    $UA_dao = new UserAccountDAO();
    $LOC_dao = new HistoryDAO();
    $acc_hist = $LOC_dao->retrieve($ID);
    $user_acc = $UA_dao->getAccountInfo($ID);
    $name = $user_acc->getName();
    if(count($acc_hist) != 0){
        $isCheckedIn = '</br>You are checked in. Click again to check out';
        $isCheckedValue = 0;
        echo "<h2>Greetings $name</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Create Date Time</th>
                    <th>Area</th>
                    <th>Check In</th>
                    <th>Check Out</td>";
                echo "</tr>";
                foreach($acc_hist as $hist){
                    $isCheckedValue = $hist->getCheckIn();
                    echo "<tr>
                            <td>{$hist->getDateTime()}</td>
                            <td>{$hist->getArea()}</td>
                            <td align='center'>{$hist->getCheckIn()}</td>
                            <td align='center'>{$hist->getCheckOut()}</td>";
                        echo "</tr>";
                }
        echo "</table>";
        if($isCheckedValue == 1){
            echo $isCheckedIn;
        }
        else{
            echo "</br>You have checked out previously. Click again to check in";
        }
    }
    else{
        echo "<h2>Sorry, this user does not have a check in/out history.</h2>";
    }
}

$accID = $_SESSION['accID'];
$name = $_SESSION['name'];

$UA_dao = new UserAccountDAO();
$LOC_dao = new HistoryDAO();
$HOUS_dao = new HousingDAO();

$account_info = $UA_dao->getAccountInfo($accID);

if(!isset($_SESSION['accID'])){
    header("Location: login.php");
    exit;
}
if(isset($_POST['insert'])){ // UPDATE HISTORY
    $history_status = $_POST['inout'];
    $area_checked = $_POST['places'];
    if($history_status == 1){ // means user did NOT CHECK OUT
        $success = $LOC_dao->add($area_checked, $accID, 0, 1);
    }
    elseif($history_status == 0){ // means user will CHECK IN NEXT
        $success = $LOC_dao->add($area_checked, $accID, 1, 0);
    }
    if($success){
        $msg = "Successful check in!";
    }
    else{
        $msg = "Sorry, there seems to be an error with check in/out";
    }
}
// create table
if($account_info == False){
    echo "Sorry, it seems that the account no longer exists. 
        Please create a new account <a href='register.php'>here</a>";
}
else{
    $role = $account_info->getRole(); // SPLIT 
    $id = $account_info->getAccId(); // GET ID

    if($role == 'User'){
        $msg = '';
        $select_area = '';
        echo "<a href='logout.php'>Logout</a>";
        echo "<hr>";
        CreateTableforUser($id); // GO TO function to check whether have history to create table
        $user_history = $LOC_dao->retrieve($id); // retrieve user history
        $places = $HOUS_dao->retrieve($id); // retrieve all saved locations

        if(count($user_history) != 0){ // IF USER HAS HISTORY AND LOCATIONS
            $last_hist_index = count($user_history) - 1;
            $last_history = $user_history[$last_hist_index]; // retrieve LASTEST history
            $last_history_isIn = $last_history->getCheckIn(); // check IN or OUT
            $last_area = $last_history->getArea();
        }
        else{ // SET TO 0. user might have locations saved, but no history
            $last_history_isIn = 0;
        }
        if( !empty($places) ){ // NO HISTORY, BUT GOT LOCATIONS
            $housing_places = [];
            foreach($places as $place){ // show which place to check in/out
                $area = $place->getArea();
                if(!in_array($area, $housing_places)){
                    $housing_places[] = $area;
                }
            }
            echo "<form action='add_history.php' method='post'>
                    <input type='hidden' name='inout' value='$last_history_isIn'>
                    <select name='places'>";
                    foreach($housing_places as $one_place){ // ensure NO DUPLICATION of places
                        if($one_place == $last_area){
                            $select_area = 'selected';
                        }
                        echo "<option value='$one_place' $select_area>$one_place</option>";
                        $select_area = '';
                    }
            echo "</select>
                    <input type='submit' name='insert' value='Check In/Out'>";
            echo "</form>";
            echo "<hr>";
            echo "Click <a href='User_location.php'>here</a> to view registered housing locations.";
        }
        else{ // NO HISTORY, NO LOCATIONS
            echo "</br><p style='color:red'>There are no registered housing locations, please add a location below first to access check in/out.";
        }
        echo "$msg";


        // add housing section
        echo "<form action='add_housing.php' method='post'>";
        echo "<table border='1'>
                <tr>
                    <th colspan='2'>Add Housing</th>
                </tr>
                <tr>
                    <td>Area:</td>
                    <td><input type='text' name='area' value='Bugis'></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><input type='text' name='address'></td>
                </tr>
                <tr>
                    <td colspan='2'><input type='submit' name='addhouse' value='Add Housing'></td>
                </tr>
            </table>";
        echo "</form>";
    }
}

?>
