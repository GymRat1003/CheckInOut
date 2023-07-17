<?php
    require_once "common.php";
    if( !isset($_SESSION['accID']) && ($_SESSION['isAdmin']) != 'Yes'){
        header("Location: login.php");
        exit;
    }
?>
<html>
    <head>
        <title>
        Tracker - Administrator Portal
        </title>
    </head>
    <body>
        <a href='logout.php'>Logout</a>
        <hr>
        <h3> Tracker - Administrator Portal</h3>
        <?php
    
            $UA_dao = new UserAccountDAO();
            $all_users = $UA_dao->retrieveAll();
            $count = 1;
            echo "<form action='process_delete.user.php' method='get'>";
                echo "<table border='1'>
                        <tr>
                            <th>Number</th>
                            <th>Account ID</th>
                            <th>Name</th>
                            <th>Delete?</th>
                        </tr>";
                foreach($all_users as $user){
                    $role = $user->getRole();
                    $aiD = $user->getAccID();
                    if($role == 'User'){
                        echo "<tr>
                                <td>$count</td>
                                <td>$aiD</td>
                                <td>{$user->getName()}</td>
                                <td><a href='process_delete_user.php?delUser=$aiD'>Delete</a></td>
                            </tr>";
                    $count++;
                    }
                }
            echo "</form>";
            // <input type='hidden' name='delUser' value='$aiD'>
        ?>
    </body>
</html>