<?php

class HousingDAO {

    # Retrieve all records as an array of Housing objects
    public function retrieveAll() {
        $connMgr = new ConnectionManager();      
        $pdo = $connMgr->getConnection();
        
        $sql = 'SELECT * FROM user_housing';
        $stmt = $pdo->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $result = [];
        while($row = $stmt->fetch()) {
            $result[] = new Housing($row['accID'], $row['area'], $row['house_address']);
        }
            
        $stmt = null;
        $pdo = null;
        return $result;
    }
    
    # Retrieve records with a specific accID
    public function retrieve($accID) {
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection();
        $sql = 'select * from user_housing where accID = :accID';
        
        $stmt = $pdo->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':accID', $accID, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = [];
        while($row = $stmt->fetch()) {
            $result[] = new Housing($row['accID'], $row['area'], $row['house_address']);
        }
        
        $stmt = null;
        $pdo = null;
        return $result;
    }
  
    # Add a housing into the database
    # Return TRUE if the operation is successful, or
    # FALSE otherwise
    public function add($accID, $area, $house_address) {
        $sql = "insert into user_housing(accID, area, house_address) values(:accID, :area, :house_address)";
        
        $connMgr = new ConnectionManager();       
        $pdo = $connMgr->getConnection();
         
        $stmt = $pdo->prepare($sql); 

        $stmt->bindParam(':accID', $accID, PDO::PARAM_STR);
        $stmt->bindParam(':area', $area, PDO::PARAM_STR);
        $stmt->bindParam(':house_address', $house_address, PDO::PARAM_STR);

        $isAddOK = $stmt->execute();
        if($isAddOK){
            $stmt = null;
            $pdo = null;
        }
        else{
            $stmt = null;
            $pdo = null;
        }
        return $isAddOK;
    }
    
    # Modify a housing in the database
    public function modify($housing) {
        $connMgr = new ConnectionManager();           
        $pdo = $connMgr->getConnection();
        
        $sql = 'update user_housing set area=:area, house_address=:house_address where accID=:accID';      
        
        $stmt = $pdo->prepare($sql);
        
        $get_accID = $housing->getAccID();
        $get_area = $housing->getArea();
        $get_house_address = $housing->getHouseAddress();

        $stmt->bindParam(':area', $get_area, PDO::PARAM_STR);
        $stmt->bindParam(':accID', $get_accID, PDO::PARAM_STR);
        $stmt->bindParam(':house_address', $get_house_address, PDO::PARAM_STR);
        
        $stmt->execute();
        $stmt = null;
        $pdo = null;
    }
    
    # Delete a record with a specific housing
    public function remove($housing) {

        $sql = 'delete from user_housing where accID=:accID and area=:area and address=:address';
        
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection();
        
        $stmt = $pdo->prepare($sql);

        $get_accID = $housing->getAccID();
        $get_area = $housing->getArea();
        $get_house_address = $housing->getHouseAddress();

        $stmt->bindParam(':area', $get_area, PDO::PARAM_STR);
        $stmt->bindParam(':accID', $get_accID, PDO::PARAM_STR);
        $stmt->bindParam(':house_address', $get_house_address, PDO::PARAM_STR);
        
        $stmt->execute();

        $stmt = null;
        $pdo = null;
    }
}
?>