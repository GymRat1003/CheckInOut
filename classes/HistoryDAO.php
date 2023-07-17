<?php

class HistoryDAO {

    # Retrieve all records as an array of History objects
    public function retrieveAll() {
        $connMgr = new ConnectionManager();      
        $pdo = $connMgr->getConnection();
        
        $sql = 'SELECT * FROM records';
        $stmt = $pdo->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $result = [];
        while($row = $stmt->fetch()) {
            $result[] = new History($row['createdatetime'], $row['area'], $row['accID'], $row['checkin'], $row['checkout']);
        }
            
        $stmt = null;
        $pdo = null;
        return $result;
    }
    
    # Retrieve a records with a specific accID
    public function retrieve($accID) {
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection();
        $sql = 'select createdatetime, area, accID, checkin, checkout from records where accID = :accID';
        
        $stmt = $pdo->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':accID', $accID, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = [];
        while($row = $stmt->fetch()) {
            $result[] = new History($row['createdatetime'], $row['area'], $row['accID'], $row['checkin'], $row['checkout']);
        }
        
        $stmt = null;
        $pdo = null;
        return $result;
    }
  
    # Add a record into the database
    # Return TRUE if the operation is successful, or
    # FALSE otherwise
    public function add($area, $accID, $checkin, $checkout) {
        $sql = 'insert into records(createdatetime, area, accID, checkin, checkout) values(current_timestamp, :area, :accID, :checkin, :checkout)';
        
        $connMgr = new ConnectionManager();       
        $pdo = $connMgr->getConnection();
         
        $stmt = $pdo->prepare($sql); 

        $stmt->bindParam(':area', $area, PDO::PARAM_STR);
        $stmt->bindParam(':accID', $accID, PDO::PARAM_STR);
        $stmt->bindParam(':checkin', $checkin, PDO::PARAM_STR);
        $stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);

        $isAddOK = FALSE;
        if ($stmt->execute()) {
            $isAddOK = TRUE;
        }
        
        $stmt = null;
        $pdo = null;

        return $isAddOK;
    }
    
    # Modify a record in the database
    public function modify($history) { // future function
        $connMgr = new ConnectionManager();           
        $pdo = $connMgr->getConnection();
        
        $sql = 'update records set createdatetime=:datetime, area=:area where accID=:accID and checkin=:checkin and checkout=:checkout';      
        
        $stmt = $pdo->prepare($sql);
        
        $get_DT = $history->getDateTime();
        $get_area = $history->getArea();
        $get_accID = $history->getAccID();
        $get_checkIn = $history->getCheckIn();
        $get_checkOut = $history->getCheckOut();


        $stmt->bindParam(':datetime', $get_DT, PDO::PARAM_STR);
        $stmt->bindParam(':area', $get_area, PDO::PARAM_STR);
        $stmt->bindParam(':accID', $get_accID, PDO::PARAM_STR);
        $stmt->bindParam(':checkin', $get_checkIn, PDO::PARAM_STR);
        $stmt->bindParam(':checkout', $get_checkOut, PDO::PARAM_STR);
        
        $stmt->execute();
        $stmt = null;
        $pdo = null;
    }
    
    # Delete a record with a given accID and specific details
    public function remove($accID, $year, $month, $day, $hour, $min, $checkin, $checkout) {

        $sql = 'delete from records where accID=:accID and year(createdatetime)=:year and month(createdatetime)=:month and day(createdatetime)=:day
                and hour(createdatetime)=:hour and minute(createdatetime)=:min and checkin=:checkin and checkout=:checkout';
        
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection();
        
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':accID', $accID, PDO::PARAM_STR);
        $stmt->bindParam(':year', $year, PDO::PARAM_STR);
        $stmt->bindParam(':month', $month, PDO::PARAM_STR);
        $stmt->bindParam(':day', $day, PDO::PARAM_STR);
        $stmt->bindParam(':hour', $hour, PDO::PARAM_STR);
        $stmt->bindParam(':min', $min, PDO::PARAM_STR);
        $stmt->bindParam(':checkin', $checkin, PDO::PARAM_STR);
        $stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);
        
        $stmt->execute();

        $stmt = null;
        $pdo = null;
    }
}
?>