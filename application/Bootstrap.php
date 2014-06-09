<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initViewHelpers() {
		$this->bootstrap('layout');
		$layout=$this->getResource('layout');
		$view=$layout->getView();
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8;');
		$view->headMeta()->appendName('keywords', 'тест');
		$view->headTitle('tests');
		$view->headTitle()->setSeparator(' ');
	
	}

	protected function _initAutoLoad() {
	
	
		$modelloader = new Zend_Application_Module_Autoloader(array(
	
				'namespace' => '',
				'basePath'=>'APPLICATION_PATH'));
	
	
		$loader = new Zend_Loader_PluginLoader();

		$fc= Zend_Controller_Front::getInstance();

	
		return $modelloader;
	

	}
	
	


}

