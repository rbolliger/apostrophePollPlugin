<?php

/**
 * PluginaPollPollTranslation form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginaPollPollTranslationForm extends BaseaPollPollTranslationForm {

    public function setup() {

        parent::setup();

        $decorator = new sfWidgetFormSchemaFormatterAAdmin($this->widgetSchema);
        $this->widgetSchema->addFormFormatter('aAdmin', $decorator);
        $this->widgetSchema->setFormFormatterName('aAdmin');
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('apostrophe');
    }

}
