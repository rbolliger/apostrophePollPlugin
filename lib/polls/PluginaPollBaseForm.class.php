<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PluginPollBaseForm
 *
 * @author Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
class PluginaPollBaseForm extends BaseForm {

    
      public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
  {
        parent::__construct($defaults, $options, $CSRFSecret);
        
        $this->setaPollFormatters();
        
    }
    
    
    /**
     * Sets formatters to poll forms in order to retrieve results 
     */

    public function setaPollFormatters() {


        $this->widgetSchema->setNameFormat('a-poll-form[%s]');

        $this->widgetSchema->setFormFormatterName('aAdmin');

        // setting translation catalogue
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('apostrophe');
    }

}
