<?php
/*
 * This file is part of the apostrophePollPlugin package.
 * (c) 2012 Raffaele Bolliger <raffaele.bolliger@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * 
 * @author Raffaele Bolliger 
 */
class PluginPollSlotEditForm extends BaseForm {

    // Ensures unique IDs throughout the page
    protected $id;

    public function __construct($id, $defaults = array(), $options = array(), $CSRFSecret = null) {
        $this->id = $id;
        parent::__construct($defaults, $options, $CSRFSecret);
    }

    public function configure() {

        $this->setWidgets(array('poll' => new sfWidgetFormDoctrineChoice(array(
                'model' => 'aPollPoll',
                'label' => 'Poll',
            ))));
        $this->setValidators(array('poll' => new sfValidatorDoctrineChoice(array(
                'model' => 'aPollPoll',
                'required' => true,
            ))));

        // Ensures unique IDs throughout the page. Hyphen between slot and form to please our CSS
        $this->widgetSchema->setNameFormat('slot-form-' . $this->id . '[%s]');

        // You don't have to use our form formatter, but it makes things nice
        $this->widgetSchema->setFormFormatterName('aAdmin');


        // setting translation catalogue
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('apostrophe');
    }

}
