<?php 
class Application_Model_Conference extends Application_Model_Model {
	
    protected $_dbtable = 'Conferences';
    
    public function getByDate($date, $id1, $id2){
        
        $where = $this->getDbTable()->select()->where('date < ?', $date-4*60*60)->where('date > ?', $date+4*60*60)->where("user_id = $id1 OR participant_id = $id2");
        $result = $this->getDbTable()->fetchAll($where);
        $rowCount = count($result);
        if($rowCount > 0){
            return false;
        }
        else {
            return true;
        }
    }
    public function save($data){
 	$this->getDbTable()->insert($data);       
    }
    

}