<?php

/**
 * PluginaPollPoll form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginaPollPollForm extends BaseaPollPollForm {

    public function setup() {

        parent::setup();

        unset(
                $this['created_at'], $this['updated_at'], $this['slug']
        );


        // checking that some polls are available
        if (false === sfConfig::get('app_aPoll_available_polls', false)) {
            throw new sfException('Cannot find any poll item in app_aPoll_available_polls. Please, define some in app.yml');
        }

        $available_polls = sfConfig::get('app_aPoll_available_polls');

        $choices = array();
        $choices_keys = array();
        foreach ($available_polls as $key => $poll) {
            $choices[$key] = isset($poll['name']) ? $poll['name'] : $key;
            $choices_keys[] = $key;
        }

        $this->widgetSchema['type'] = new sfWidgetFormChoice(array('choices' => $choices));

        $this->validatorSchema['type'] = new sfValidatorAnd(
                        array(
                            new sfValidatorChoice(array('choices' => $choices_keys, 'required' => true)),
                            new aPollValidatorPollItem(array('poll_items' => sfConfig::get('app_aPoll_available_polls'))),
                        ),
                        array('halt_on_error' => true)
        );


        // setting translation catalogue
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('apostrophe');
    }

}
