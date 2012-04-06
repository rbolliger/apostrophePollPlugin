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

    public function __construct($defaults = array(), $options = array(), $CSRFSecret = null) {
        parent::__construct($defaults, $options, $CSRFSecret);

        $this->setaPollFormatters();
    }

    /**
     * Sets formatters to poll forms in order to retrieve results 
     */
    public function setaPollFormatters() {

        $this->setWidget('poll_id', new sfWidgetFormInputHidden());
        $this->setValidator('poll_id', new sfValidatorChoice(array(
                    'choices' => array($this->getDefault('poll_id')),
                    'empty_value' => array($this->getDefault('poll_id')),
                )));

        $this->setWidget('slot_name', new sfWidgetFormInputHidden());
        $this->setValidator('slot_name', new sfValidatorChoice(array(
                    'choices' => array($this->getDefault('slot_name')),
                    'empty_value' => array($this->getDefault('slot_name')),
                )));

        $this->setWidget('permid', new sfWidgetFormInputHidden());
        $this->setValidator('permid', new sfValidatorChoice(array(
                    'choices' => array($this->getDefault('permid')),
                    'empty_value' => array($this->getDefault('permid')),
                )));

        $this->setWidget('pageid', new sfWidgetFormInputHidden());
        $this->setValidator('pageid', new sfValidatorChoice(array(
                    'choices' => array($this->getDefault('pageid')),
                    'empty_value' => array($this->getDefault('pageid')),
                )));


        $this->widgetSchema->setNameFormat('a-poll-form[%s]');

        $this->widgetSchema->setFormFormatterName('aAdmin');

        // setting translation catalogue
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('apostrophe');
    }

}
