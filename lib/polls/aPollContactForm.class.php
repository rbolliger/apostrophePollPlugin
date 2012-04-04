<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aPollContactForm
 *
 * @author Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
class aPollContactForm extends aPollBaseForm {


  public function configure()
  {
      
      
    $this->setWidgets(array(
        'author_email' => new sfWidgetFormInputText(),
        'author_name' => new sfWidgetFormInputText(),
        'object' =>     new sfWidgetFormInputText(),
        'message' =>    new sfWidgetFormTextarea(),
        ));
    $this->setValidators(array(
        'author_email' => new sfValidatorEmail(array('required' => true)),
        'author_name' => new sfValidatorString(array('required' => true)),
        'object' =>     new sfValidatorString(array('required' => false)),
        'message' =>    new sfValidatorString(array('required' => true)),
        ));
    $this->getWidgetSchema()->setLabels(array(
        'author_email' => "Email",
        'author_name' => "Name",
        'object' => "Object",
        'message' =>    "Message",
        ));
    

  }
 
}
