<?php 
class Application_Model_User extends Application_Model_Model {
	
	protected $_dbtable = 'Users';
	
	public function save($data){
		
		$this->getDbTable()->insert($data);
		
	}
        
        public function delete($id){
            $data = array();
            $data['status'] = 'deleted';
            $where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $id);
            $this->getDbTable()->update($data, $where);
        }
	
        public function userlist(){
            $db = $this->getDbTable();
            $adapter = $db->select()
                          ->from(array('u'=>'users'), array('u.id as u_id', 'u.name', 'u.lastname', 'uc.usercount', 'uc.max_u_date', 'uc.min_u_date', 'pc.max_p_date', 'pc.min_p_date', 'pc.participantcount'))
                          ->setIntegrityCheck(false)
                          ->joinLeft(array('uc'=>new Zend_Db_Expr('(select id, user_id, count(user_id) as usercount, max(date) as max_u_date, min(date) as min_u_date  from conferences group by user_id)')), 'u.id = uc.user_id')
                          ->joinLeft(array('pc'=>new Zend_Db_Expr('(select id, participant_id, count(participant_id) as participantcount, max(date) as max_p_date, min(date) as min_p_date from conferences group by participant_id)')), 'u.id = pc.participant_id')                          
                          ->where('u.status = ? ', 'active');
             
            return new Zend_Paginator_Adapter_DbSelect($adapter);
//SELECT u.id, u.name, u.lastname, uc.usercount, uc.max_u_date, uc.min_u_date, pc.max_p_date, pc.min_p_date, pc.participantcount from users as u 
//LEFT JOIN (select id, user_id, count(user_id) as usercount, max(date) as max_u_date, min(date) as min_u_date  from conferences group by user_id) as uc ON u.id = uc.user_id  
//LEFT JOIN (select id, participant_id, count(participant_id) as participantcount, max(date) as max_p_date, min(date) as min_p_date from conferences group by participant_id) as pc ON u.id = pc.participant_id 
//where u.status ='active';            
        }
        
        public function users(){
            
            $where = $this->getDbTable()->select()->where('status = ?', 'active');
            $result = $this->getDbTable()->fetchAll($where);
            if ($result){
              return $result->toArray();
            }
            else {
                return array();               
            }
        }
        public function getById($id){
            $where = $this->getDbTable()->select()->where('id = ?', $id);
            $result = $this->getDbTable()->fetchRow($where);
            return $result->toArray();
        }
}
