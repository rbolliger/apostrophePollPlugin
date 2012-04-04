<?php

/**
 * Checks that a poll item configured in app.yml satisfies all requirements:
 *  * Definition of poll item in app.yml
 *  * Availability of form class
 *  * Form class extends aPollBaseForm
 * 
 *
 * @author Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
class aPollValidatorPollItem extends sfValidatorBase {

    /**
     * Configures the current validator.
     * This method allows each validator to add options and error messages during validator creation.
     * Available options:
     *  * max: The maximum value allowed
     *  * min: The minimum value allowed
     * Available error codes:
     *  * max
     *  * min
     *
     * @param array $options   An array of options
     * @param array $messages  An array of error messages
     * @see sfValidatorBase
     */
    protected function configure($options = array(), $messages = array()) {

        $this->addRequiredOption('poll_items');
        
        $this->addMessage('form_field', 'Field "form" is not defined in %poll%.');
        $this->addMessage('form_class', 'Class %form% defined in %poll% does not exist or is not autoloaded. Place it in a lib directory.');
        $this->addMessage('form_extends', 'Class %form% defined in %poll% does not extend aPollBaseForm.');
    
    }

    /**
     * Cleans the input value.
     *
     * @param  mixed $value  The input value
     * @return mixed The cleaned value
     * @throws sfValidatorError
     */
    protected function doClean($value) {

        $polls = $this->getOption('poll_items');
        $poll_app = 'app_aPoll_available_polls_'.$value;

        // checks that the item exists
        if (!isset($polls[$value])) {
            throw new sfValidatorError($this, 'form_field', array('poll' => $poll_app));
        }
        $poll = $polls[$value];
        
        // checks if form field is defined
        if (!isset($poll['form'])) {
            throw new sfValidatorError($this, 'form_field', array('poll' => $poll_app));
        }
        $form = $poll['form'];
        
        // checks if form class is instantiated
        if (!class_exists($form)) {
            throw new sfValidatorError($this, 'form_class', array('poll' => $poll_app, 'form' => $form));
        }  
        
        // checks if form class is based on aPollBaseForm
        $object = new $form();
        if (!($object instanceof aPollBaseForm)) {
            throw new sfValidatorError($this, 'form_extends', array('poll' => $poll_app, 'form' => $form));
        }
        
                
        return $value;
    }

}

