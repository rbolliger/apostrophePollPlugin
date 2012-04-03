<?php

class PluginPollSlotViewForm extends BaseForm {

    // Ensures unique IDs throughout the page
    protected $id;

    public function __construct($id, $defaults = array(), $options = array(), $CSRFSecret = null) {
        $this->id = $id;
        parent::__construct($defaults, $options, $CSRFSecret);
    }

    public function configure() {

        $this->setWidgets(array('poll' => new sfWidgetFormInputText()));

        $available_polls = sfConfig::get('app_aPoll_available_polls');

        $this->setValidators(array('poll' => new sfValidatorAnd(
                    array(
                        new sfValidatorChoice(array('choices' => array_keys($available_polls), 'required' => true)),
                        new aPollValidatorPollItem(array('poll_items' => $available_polls)),
                    ),
                    array('halt_on_error' => true)
                )));

        // Ensures unique IDs throughout the page. Hyphen between slot and form to please our CSS
        $this->widgetSchema->setNameFormat('a-poll-form-view-' . $this->id . '[%s]');

        // You don't have to use our form formatter, but it makes things nice
        $this->widgetSchema->setFormFormatterName('aAdmin');


        // setting translation catalogue
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('apostrophe');
        
        $this->disableCSRFProtection();
    }

}
