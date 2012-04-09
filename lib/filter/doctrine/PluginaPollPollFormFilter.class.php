<?php

/**
 * PluginaPollPoll form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     Raffaele Bolliger <raffaele.bolliger at gmail.com>
 * @version    SVN: $Id: sfDoctrineFormFilterPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginaPollPollFormFilter extends BaseaPollPollFormFilter {

    public function setup() {

        parent::setup();

        // checking that some polls are available
        if (false === sfConfig::get('app_aPoll_available_polls', false)) {
            throw new sfException('Cannot find any poll item in app_aPoll_available_polls. Please, define some in app.yml');
        }

        $available_polls = sfConfig::get('app_aPoll_available_polls');

        $choiches = array();
        foreach ($available_polls as $key => $poll) {
            $choiches[$key] = isset($poll['name']) ? $poll['name'] : $key;
        }

        $this->widgetSchema['type'] = new sfWidgetFormChoice(array('choices' => $choiches, 'multiple' => true, 'expanded' => true));

        
        $culture = sfContext::getInstance()->getUser()->getCulture(); 
        $date_options = array(
                        'image' => '/apostrophePlugin/images/a-icon-datepicker.png',
                        'culture' => $culture,
                        'config' => '{changeMonth: true,changeYear: true}',
                    );
        

        $this->setWidget('published_from', new sfWidgetFormFilterDate(array(
            'from_date' => new aWidgetFormJQueryDate($date_options),
            'to_date' => new aWidgetFormJQueryDate($date_options),
            )));

        $this->setWidget('published_to', new sfWidgetFormFilterDate(array(
            'from_date' => new aWidgetFormJQueryDate($date_options),
            'to_date' => new aWidgetFormJQueryDate($date_options),
            )));


        // setting translation catalogue
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('apostrophe');
    }

}
