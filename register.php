<html>
    <head>
        <title>
            Tracker - Register
        </title>
    </head>
    <body>

</html>
<?php

require_once "common.php";
// admin account code is abc123
$accID = '';
$name = '';
$og_password = '';
$conf_password = '';
$admin_code = '';
$msg = '';

if(isset($_POST['signup'])){ // form submitted
    $user_dao = new UserAccountDAO();
    $accID = $_POST['accID'];
    $name = $_POST['name'];
    $og_password = $_POST['og_pass'];
    $conf_password = $_POST['conf_pass'];
    $admin_code = $_POST['admin_account_code'];
    $admin_key = $user_dao->getAdminKey();
    $accID_check = $user_dao->CheckAccExist($accID);

    if($admin_code != $admin_key && ($admin_code != '')){ // not blank means trying to be admin
        $msg = "<p style='color:red'>Admin account code mismatch!";
    }
    elseif($accID_check){
        $msg = "<p style='color:red'>Sorry, this Account ID already exists. Please try with another Account ID.";        
    }
    elseif( ($og_password != $conf_password)){
        $msg = "<p style='color:red'>Password and Confirm Password do not match!";
    }
    elseif($admin_code == ''){ // blank admin code means helper
        $add_user = $user_dao->addUserAccount($accID, $name, $conf_password, 'User');
        if($add_user){
            $msg = "<p style='color:green'>You have successfully registered</br>
                    Click <a href='login.php'>here</a> to login.";
        }
        else{
            $msg = "<p style='color:red'>Registration Failed! Please check your entry again.";
        }
    }
    elseif( ($admin_code == $admin_key)){ // if admin code correct
        $add_user = $user_dao->addUserAccount($accID, $name, $conf_password, 'Admin');
        if($add_user){
            $msg = "<p style='color:green'>You have successfully registered</br>
                    Click <a href='login.php'>here</a> to login.";
        }                    
        else{
            $msg = "<p style='color:red'>Registration Failed! Please check your entry again.";
            $name = 'Any name';
            $admin_code = '';
        }
    }
}
echo 
    "
        <h1>Register</h1>
        <form action='register.php' method='post'>
            <table>
                <tr>
                    <td>
                        Account ID:
                    </td>
                    <td>
                        <input type='text' required name='accID' value='$accID'>
                    </td>
                </tr>
                <tr>
                    <td>
                        Name:
                    </td>
                    <td>
                        <input type='text' required name='name' value='$name'>
                    </td>
                </tr>
                <tr>
                    <td>
                        Password:
                    </td>
                    <td>
                        <input type='password' required name='og_pass'>
                    </td>
                </tr>
                <tr>
                    <td>
                        Confirm Password:
                    </td>
                    <td>
                        <input type='password' required name='conf_pass'>
                    </td>
                </tr>
                <tr>
                <td>
                    Admin Account Code:
                </td>                            
                <td>
                    <input type='text' name='admin_account_code' value='$admin_code'/> 
                </td>
            </tr>
            </table>
            <input type='submit' name='signup' value='Sign Up'></br></br>";
            echo "Already have an account? Sign in <a href='login.php'>here</a>";
        echo "</form>";

    echo "$msg"; // if any errors with registering
?>