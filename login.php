<?php
    require_once "common.php";    
?>
<html>
    <head>
        <title>
            Tracker - Login
        </title>
    </head>
    <body>
        
    <img src=''>
    <h2>Login</h2>
    <?php
        
        // <p style='color:green'>
        // <p style='color:red'>
        $msg = '';
        $set_accID = '';
        if(isset($_POST['accID']) && isset($_POST['password'])){
            $accID = $_POST['accID'];
            $set_accID = $accID;
            $pass = $_POST['password'];
            $get_role = $_POST['role'];
            $user_dao = new UserAccountDAO();
            $get_user = $user_dao->getUserAccount($accID, $pass);
            if($get_user != null){ // accID and password CORRECT
                $role = $get_user->getRole(); // check role for RETURNED
                $name = $get_user->getName();
                # var_dump($role);
                if($get_role != $role){ // accID & password correct BUT wrong role
                    $msg = "<p style='color:red'>Incorrect user role. Try again.";
                }
                else{ // successful login
                    if($get_role == 'User'){
                        $_SESSION['accID'] = $accID;
                        $_SESSION['name'] = $name;
                        $_SESSION['isAdmin'] = 'No';
                        header("Location: user_history.php");
                        exit;
                    }
                    else{
                        $_SESSION['accID'] = $accID;
                        $_SESSION['name'] = $name;
                        $_SESSION['isAdmin'] = 'Yes';
                        header("Location: admin.php");
                        exit;
                    }
                }
            }
            else{
                $msg = "<p style='color:red'>Failed Login. Try again.";                
            }
        }
        echo 
        "
            <form method='post'>
                <table>
                    <tr>
                        <td>
                            Account ID:
                        </td>
                        <td>
                            <input type='text' required name='accID' value='$set_accID'/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Password:
                        </td>                            
                        <td>
                            <input type='password' required name='password'/>
                        </td>
                    </tr>
                </table>
                
                <br/>
                
                <input type='radio' name='role' value='User' checked/> I am user
                <input type='radio' name='role' value='Admin'/> I am admin 

                <br/>
                <br/>
                
                <input type='submit' name='login' value='Log In'/></br></br>";

                echo "No account? Create one <a href='register.php'>here</a>";
            echo "</form>";

        echo "$msg";
    ?>
    </body>
</html>

