<?php
require_once 'Zend/Filter/Interface.php';

class Zend_Filter_SimpleStripTags implements Zend_Filter_Interface
{
	
	/*custom class*/
	
	public function filter($value)
	{
		//return($value);
		return strip_tags($value, '<p><a><div><span><iframe><table><td><tr><h1><h2><h3><br><em><ul><ol><li><hr><img>');
	}
	
}
