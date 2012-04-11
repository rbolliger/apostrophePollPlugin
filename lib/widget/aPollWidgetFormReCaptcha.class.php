<?php

/**
 * This solution is inspired from Mike Purcell's solution. 
 * See http://melikedev.com/2011/05/24/symfony-add-recaptcha-to-jquery-dialog-lightbox/ 
 */

/**
 * Extending plugin functionality, see parent class for full docs
 */
class aPollWidgetFormReCaptcha extends sfWidgetFormReCaptcha {

    /**
     * @see sfWidgetForm
     */
    public function render($name, $value = null, $attributes = array(), $errors = array()) {
        $server = $this->getServerUrl();
        $key = $this->getOption('public_key');

        if ((array_key_exists('context', $attributes)) &&
                ($attributes['context'] == 'ajax')) {

            // Arbitrary flag, unset it
            unset($attributes['context']);

            return
                    '<div id="captchaWrap"></div>' .
                    javascript_tag("
            Recaptcha.create('" . $key . "', 'captchaWrap', {" .
                            "theme:'" . $this->getOption('theme') . "'," .
                            " lang:'" . $this->getOption('culture') . "'" .
                            "});"
            );
        }


        parent::render($name, $value, $attributes, $errors);
    }

}
