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
        $this->addMessage('view_template', 'The partial "%partial%" defined in "view_template" field cannot be found.');
        $this->addMessage('submit_action', 'The action "%action%" defined in the "submit_action" field cannot be found.');
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
        $poll_app = 'app_aPoll_available_polls_' . $value;

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

        // checks if view_template has been defined and if the file exist
        if (isset($poll['view_template'])) {

            $templateName = $poll['view_template'];

            $list = $this->getModuleAndAction($templateName);

            $template = '_'.$list['action'] . '.php';
            
            $directory = sfContext::getInstance()->getConfiguration()->getTemplateDir($list['module'], $template);
           
            if (!is_readable($directory . '/' . $template)) {
                throw new sfValidatorError($this, 'view_template', array('partial' => $templateName));
            }
        }

        // checks if submit_action has been defined and if the action exist
        if (isset($poll['submit_action'])) {

            $list = $this->getModuleAndAction($poll['submit_action']);

            $controller = sfContext::getInstance()->getController();
            
            if (!$controller->actionExists($list['module'], $list['action'])) {
                throw new sfValidatorError($this, 'submit_action', array('action' => $poll['submit_action']));
            }
        }


        return $value;
    }

    protected function getModuleAndAction($ref) {

        if (false !== $sep = strpos($ref, '/')) {
            $moduleName = substr($ref, 0, $sep);
            $templateName = substr($ref, $sep + 1);
        } else {
            $moduleName = 'aPollSlot';
            $templateName = $ref;
        }
        

        return array('module' => $moduleName, 'action' => $templateName);
    }

}

