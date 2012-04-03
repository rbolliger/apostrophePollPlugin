<?php

/**
 * PluginaPollPollNewPost form.
 *
 * @package    aPollAdmin
 * @subpackage form
 * @author     Raffaele Bolliger <raffaele.bolliger at gmail.com>
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginaPollPollNewPollForm extends BaseForm
{
  public function configure()
  {
    parent::configure();
    $this->setWidget('title', new sfWidgetFormInputText());
    $this->setValidator('title', new sfValidatorString(array('min_length' => 2, 'required' => true)));
    $this->widgetSchema->setNameFormat('a_poll_poll_new_poll[%s]');
    $this->widgetSchema->setFormFormatterName('aAdmin');
  }
}
