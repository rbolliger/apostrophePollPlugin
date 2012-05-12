<?php

/**
 * PluginaPollAnswer form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     Raffaele Bolliger <raffaele.bolliger at gmail.com>
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginaPollAnswerForm extends BaseaPollAnswerForm {

    public function setup() {
        parent::setup();

        $culture = sfContext::getInstance()->getUser()->getCulture();
        $languages = sfCultureInfo::getInstance($culture)->getLanguages(sfConfig::get('app_a_i18n_languages'));

        $this->setWidget('culture', new sfWidgetFormChoice(array('choices' => $languages)));
    }

}
