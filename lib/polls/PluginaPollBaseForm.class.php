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

        try {
            $con->beginTransaction();

            $this->doSave($con);

            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();

            throw $e;
        }

    }

    protected function doSave($con) {


        if (null === $con) {
            $con = $this->getConnection();
        }

        $pollid = $this->getValue('poll_id');

        // creating a new answer
        $answer = new aPollAnswer();
        $answer->setPollId($pollid);
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

            if (null !== $this->getValue($field)) {

                $af = new aPollAnswerField();
                $af->setPollId($pollid);
                $af->setAnswerId($aid);
                $af->setName($field);
                $af->setValue($this->getValue($field));

                $answer_fields->add($af);
            }
        }

        // Once all fields set, we save all of them
        if (count($answer_fields)) {
            $answer_fields->save();
        }

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

}
