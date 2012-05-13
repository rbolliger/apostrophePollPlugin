<?php

/*
 * This file is part of the apostrophePollPlugin package.
 * (c) 2012 Raffaele Bolliger <raffaele.bolliger@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
    
    $this->setFieldsToSave(array('author_email', 'author_name', 'object', 'message'));
    

  }
 
}
