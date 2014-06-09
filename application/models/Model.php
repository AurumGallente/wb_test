<?php 
class Application_Model_Model {
	
	protected $_dbtable;
	
	public function getDbTable()
	
	{	
		$this->setDbTable('Application_Model_DbTable_'.$this->_dbtable);
			return $this->_dbTable;
	
	}
	
	public function setDbTable($dbTable)
	
	{	
		if (is_string($dbTable)) {
	
			$dbTable = new $dbTable();
	
		}
	
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
	
			throw new Exception('Invalid table data gateway provided');
	
		}	
		$this->_dbTable = $dbTable;	
		return $this;
	
	}
}

?>