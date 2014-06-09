<?php

class Application_Form_UserForm extends Zend_Form {
    
    public function __construct($options = null) {
        parent::__construct($options);
    
    $name = new Zend_Form_Element_Text('name');
    $name->setLabel('Имя')
         ->addValidator('notEmpty')
         ->addFilter('StringTrim')
         ->addFilter('StripTags')
         ->setRequired('true')   
            ;
    $lastname = new Zend_Form_Element_Text('lastname');
    $lastname->setLabel('Фамилия')
             ->addValidator('notEmpty')
             ->addFilter('StringTrim')
             ->addFilter('StripTags')
             ->setRequired('true') 
            ;
    $password = new Zend_Form_Element_Password('password');
    $password->setLabel('пароль')
             ->addValidator('notEmpty')
             ->setRequired('true') 
            ;
    $submit =  new Zend_Form_Element_Submit('отправить');
    
    $this->addElements(array($name, $lastname, $password, $submit));
    $this->setMethod('post');
    }
}

