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

    protected $fields_to_save = null;

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

        $this->setWidget('poll_type', new sfWidgetFormInputHidden());
        $this->setValidator('poll_type', new sfValidatorChoice(array(
                    'choices' => array($this->getDefault('poll_type')),
                    'empty_value' => array($this->getDefault('poll_type')),
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

        $this->setWidget('remote_address', new sfWidgetFormInputHidden());
        $this->setValidator('remote_address', new sfValidatorChoice(array('choices' => array($this->getDefault('remote_address')))));

        $this->setWidget('culture', new sfWidgetFormInputHidden());
        $this->setValidator('culture', new sfValidatorChoice(array('choices' => array($this->getDefault('culture')))));



        if (!$this->getDefault('poll_type')) {
            $captcha_display = true;
        } else {
            $captcha_display = aPollToolkit::getCaptchaDoDisplay($this->getDefault('poll_type'));
        }

        // add captcha widget and validator, if requested for this form
        if ($captcha_display) {

            $this->setWidget('captcha', $this->getCaptchaWidget());

            $this->widgetSchema['captcha']->setLabel('Anti-spam check');

            $this->setValidator('captcha', $this->getCaptchaValidator());
        }



        $this->widgetSchema->setNameFormat('a-poll-form[%s]');

        $this->widgetSchema->setFormFormatterName('aAdmin');

        // setting translation catalogue
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('apostrophe');
    }

    /**
     * Saves the current object to the database.
     *
     * The object saving is done in a transaction and handled by the doSave() method.
     *
     * @param mixed $con An optional connection object
     *
     * @return mixed The current saved object
     *
     * @see doSave()
     * 
     * @throws sfValidatorError If the form is not valid
     */
    public function save($con = null) {
        if (!$this->isValid()) {
            throw $this->getErrorSchema();
        }

        if (null === $con) {
            $con = $this->getConnection();
        }

        $request = sfContext::getInstance()->getRequest();
        $response = sfContext::getInstance()->getResponse();
        $actual_cookie = aPollToolkit::getCookieContent($request);
        $poll = Doctrine_Core::getTable('aPollPoll')->findOneById($this->getValue('poll_id'));

        aPollToolkit::setShowPollToCookie($request, $response, $poll, aPollToolkit::getPollAllowMultipleSubmissions($poll));

        try {
            $con->beginTransaction();

            $answer = $this->doSave($con);

            $con->commit();
        } catch (Exception $e) {

            $response->setCookie($actual_cookie);

            $con->rollBack();

            throw $e;
        }

        return $answer;
    }

    protected function doSave($con) {


        if (null === $con) {
            $con = $this->getConnection();
        }

        $pollid = $this->getValue('poll_id');

        // creating a new answer
        $answer = new aPollAnswer();
        $answer->setPollId($pollid);
        $answer->setRemoteAddress($this->getValue('remote_address'));
        $answer->setCulture($this->getValue('culture'));
        $answer->save();

        $aid = $answer->getId();


        // recovering all fields that must be saved in the DB
        $answer_fields = new Doctrine_Collection('aPollAnswerField');

        $fields_to_save = $this->getFieldsToSave();

        if (null === $fields_to_save) {

            throw new sfException('To save this form, you must define which fields must be saved using setFieldsToSave()');
        }

        // for each field, we create a new aPollAnswerField, which is linked to a aPollAnswer 
        // (and obviously to the poll)
        foreach ($fields_to_save as $field) {

            $v = $this->getValue($field);

            if (is_null($v) || '' === $v) {

                continue;
            }

            $af = new aPollAnswerField();
            $af->setPollId($pollid);
            $af->setAnswerId($aid);
            $af->setName($field);
            $af->setValue($this->getValue($field));

            $answer_fields->add($af);
        }

        // Once all fields set, we save all of them
        if (count($answer_fields)) {
            $answer_fields->save();
        }

        return $answer;
    }

    public function getFieldsToSave() {

        return $this->fields_to_save;
    }

    public function setFieldsToSave($fields = null) {

        if (null === $fields) {
            throw new sfException('$fields must be an array containing the names of the form fields to be saved');
        }


        if (null === $this->fields_to_save) {
            $this->fields_to_save = $fields;
        } else {
            $this->fields_to_save = array_merge($this->fields_to_save, $fields);
        }
    }

    public function getConnection() {
        return Doctrine_Manager::connection();
    }

    protected function getCaptchaWidget() {

        return new aPollWidgetFormReCaptcha(array(
                    'public_key' => sfConfig::get('app_recaptcha_public_key'),
                    'culture' => $this->getDefault('culture'),
                        ),
                        array('context' => 'ajax',));
    }

    protected function getCaptchaValidator() {

        return new sfValidatorReCaptcha(array(
                    'private_key' => sfConfig::get('app_recaptcha_private_key')
                ));
    }

    public static function listenToRequestParametersFilterEvent(sfEvent $event, $value) { 
        
        $params = $event->getParameters();
        
        
        
        if(!aPollToolkit::getCaptchaDoDisplay($params['poll_type'])) {
            return array();
        }
        
        
        
        $captcha = array(
            'recaptcha_challenge_field' => isset($value['recaptcha_challenge_field']) ? $value['recaptcha_challenge_field'] :  null,
            'recaptcha_response_field' => isset($value['recaptcha_response_field']) ? $value['recaptcha_response_field'] : null,
        );
        
        return array('captcha' => $captcha);
    }

}
