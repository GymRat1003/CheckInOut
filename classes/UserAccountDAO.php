<?php

class UserAccountDAO {

    public function retrieveAll(){ // retrieve all user accounts
        $conn = new ConnectionManager();
        $pdo = $conn->getConnection();
        $sql = "select * from user";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = [];
        while($row = $stmt->fetch()){
            $result[] = new UserAccount($row['accID'], $row['name'], $row['password'], $row['UserType']);
        }
        return $result;
    } 
    public function addUserAccount($accID, $name, $password, $role) { // for register
        $sql = '
            INSERT INTO user
                (accID, name, password, UserType)
            VALUES
                (:accID, :name, :hashed_password, :role);
        ';

        $conn = new ConnectionManager();
        $pdo = $conn->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':accID', $accID, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':hashed_password', $hashed, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $isAddOK = $stmt->execute();

        if($isAddOK){
            $stmt = null;
            $pdo = null;
            return True;
        }
        else{
            $stmt = null;
            $pdo = null;
            return False;
        }
    }

    public function getUserAccount($accID, $password) { // for login
        $sql = '
            SELECT
                *
            FROM
                user
            WHERE
                accID = :accID
        ';

        $conn = new ConnectionManager();
        $pdo = $conn->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':accID', $accID, PDO::PARAM_STR);
        
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $user_exist = $stmt->execute();
        if($user_exist){ // user exist
            if($row = $stmt->fetch()){ // get user
                $user = new UserAccount($row['accID'], $row['name'], $row['password'], $row['UserType']);
                $hashed_password = $user->getHashedPassword();
                $correct_pass = password_verify($password, $hashed_password);

                if($correct_pass){ // user exist AND password correct
                    $stmt = null;
                    $pdo = null;
                    return $user;
                }
                else{ // user exist BUT password wrong
                    $stmt = null;
                    $pdo = null;
                    return NULL;
                }
            }
        }
        else{ // user does NOT exist
            $stmt = null;
            $pdo = null;
            return NULL;            
        }

    }
    public function getAdminKey(){ // can create different admin keys for different functions. By right suppose to be another DAO
        $sql = 'select * from admin_keys limit 1';
        $conn = new ConnectionManager();
        $pdo = $conn->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($row = $stmt->fetch()){
            $key = ($row['specialkey']);
            $stmt = null;
            $pdo = null;
            return $key;
        }
    }
    public function CheckAccExist($accID){
        $sql = 'select * from user where accID = :accID';
        $conn = new ConnectionManager();
        $pdo = $conn->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':accID', $accID, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($row = $stmt->fetch()){
            if($row['accID'] = null){
                $stmt = null;
                $pdo = null;
                return False;                    
            }
            else{
                $stmt = null;
                $pdo = null;
                return True;
            }
        }
        else{
            $stmt = null;
            $pdo = null;
            return False;
        }
    }
    public function getAccountInfo($accID){
        $conn = new ConnectionManager();
        $pdo = $conn->getConnection();
        $sql = "select * from user where accID=:ID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ID', $accID, PDO::PARAM_STR);
        $success = $stmt->execute();
        if($success){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if($row = $stmt->fetch()){
                $result = new UserAccount($row['accID'], $row['name'], $row['password'], $row['UserType']);
            }
        }
        else{
            $stmt = null;
            $pdo = null;
            return False;
        }
        $stmt = null;
        $pdo = null;
        return $result;
    }
    public function deleteAccount($accID){
        $conn = new ConnectionManager();
        $pdo = $conn->getConnection();
        $sql = "delete from user where accID=:ID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ID', $accID, PDO::PARAM_STR);

        $isDelOK = $stmt->execute();

        if($isDelOK){
            $stmt = null;
            $pdo = null;
            return True;
        }
        else{
            $stmt = null;
            $pdo = null;
            return False;
        }       
    }
}
?>