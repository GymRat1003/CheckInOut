<?php

require_once 'common.php';
if(!isset($_SESSION['accID'])){
    header("Location: login.php");
    exit;
}

$id = $_SESSION['accID'];
$name = $_SESSION['name'];
$HOUS_dao = new HousingDAO();
$housings = $HOUS_dao->retrieve($id);

echo "<a href='logout.php'>Logout</a>";
echo "<hr>";
// create table
echo "<h1>Housing Locations</h1>";
echo "<h3>Greetings, $name</h3></br>";
if( count($housings) != 0){
    $count = 1;
    echo "<table border='1'>
            <tr>
                <th>Number</td>
                <th>Area</th>
                <th>Address</th>
            </tr>";
            foreach($housings as $housing){
                echo "<tr>
                        <td>$count</td>
                        <td>{$housing->getArea()}</td>
                        <td>{$housing->getHouseAddress()}</td>
                    </tr>";
                $count++;
            }
    echo "</table>";
    echo "</br>Click <a href='User_history.php'>here</a> to go back to user history";
}
else{
    echo "You do not have any housing locations. Please click <a href='User_history.php'>here</a> to add a housing";
}

?>
