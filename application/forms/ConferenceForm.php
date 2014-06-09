<?php

class Application_Form_ConferenceForm extends Zend_Form {
    
    public function __construct($options = null) {
    parent::__construct($options);
            
        $user = new Application_Model_User();
        $users = $user->users();
        
        $list = array();
        
        foreach ($users as $u) {
            
            $list[$u['id']] = $u['name'].' '.$u['lastname'];
        }
        
        $user_id = new Zend_Form_Element_Select('user_id');
        $user_id->setLabel('Пользователь')
                ->setMultiOptions($list)               
                ;
        $participant_id = new Zend_Form_Element_Select('participant_id');
        $participant_id->setLabel('Участник')
                ->setMultiOptions($list)               
                ;
        $date = new Zend_Form_Element_Text('date');
        $date->setLabel('время начала')
             ->addValidator('notEmpty')
             ->setAttrib('id', 'datetimepicker')
             ->setRequired(true)           
                        ;
                ;
        $submit = new Zend_Form_Element_Submit('создать');
        
        $this->addElements(array($user_id, $participant_id, $date, $submit));
                
    
      }    
    }