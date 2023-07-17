<?php
    require_once('common.php');
    if( !isset($_SESSION['accID']) && ($_SESSION['isAdmin']) != 'Yes'){
        header("Location: login.php");
        exit;
    }
    $UA_dao = new UserAccountDAO();
    $success = false;
    $user_delete = $_GET['delUser'];
    $user = $UA_dao->getAccountInfo($user_delete);
    if($user){
        echo "<form method='post'>";
        echo "<table border='1'>
                <tr>
                    <th colspan='2'>Currently Deleting</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <td>{$user->getAccID()}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{$user->getName()}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{$user->getRole()}</td>
                </tr>
            </table>";
            
        echo "</br><input type='submit' name='delete' value='Confirm Deletion'>";

        echo "</form>";
    }
    if(isset($_POST['delete'])){
        $success = $UA_dao->deleteAccount($user_delete);
        if($success){
            echo "<h3>Delete was successful!</h3>";
            echo "</br>Go <a href='admin.php'>back</a>";
        }
        else{
            echo "<h1>User could not be deleted. Please check whether there is existing history and location records.</h1>";
            echo "</br>Go <a href='admin.php'>back</a>";
        }
    }

?>