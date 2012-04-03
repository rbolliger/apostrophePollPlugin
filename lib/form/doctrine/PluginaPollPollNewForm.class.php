<?php

/**
 * PluginaPollPollNew form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginaPollPollNewForm extends BaseaPollPollNewForm {

    public function setup() {

        parent::setup();


        $this->setWidget('title', new sfWidgetFormInputText());
        $this->setValidator('title', new sfValidatorAnd(array(
               
                new sfValidatorString(array(
                    'min_length' => 2,
                    'required' => true,
                )),
                new sfValidatorDoctrineUnique(array('model' => 'aPollPollNew', 'column' => 'title')),
        )));

        $this->widgetSchema->setFormFormatterName('aAdmin');
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('apostrophe');
    }

}
