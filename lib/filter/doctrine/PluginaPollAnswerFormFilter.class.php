<?php

/**
 * PluginaPollAnswer form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     Raffaele Bolliger <raffaele.bolliger at gmail.com>
 * @version    SVN: $Id: sfDoctrineFormFilterPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginaPollAnswerFormFilter extends BaseaPollAnswerFormFilter {

    public function setup() {

        parent::setup();
        
        
        $this->setWidget('poll_id', new sfWidgetFormInputHidden());
        $this->setValidator('poll_id', new sfValidatorChoice(array(
                    'choices' => array($this->getDefault('poll_id')),
                    'empty_value' => array($this->getDefault('poll_id')),
                )));

        $culture = sfContext::getInstance()->getUser()->getCulture();
        $date_options = array(
            'image' => '/apostrophePlugin/images/a-icon-datepicker.png',
            'culture' => $culture,
            'config' => '{changeMonth: true,changeYear: true}',
        );


        $this->setWidget('created_at', new sfWidgetFormFilterDate(array(
                    'from_date' => new aWidgetFormJQueryDate($date_options),
                    'to_date' => new aWidgetFormJQueryDate($date_options),
                )));

    }

}
