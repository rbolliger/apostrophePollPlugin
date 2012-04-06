<?php

/**
 * Description of aPollToolkit
 *
 * @author Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
class aPollToolkit {

    /**
     * Checks that the poll instance defined in app_aPoll_available_polls is correctly
     * defined.
     *
     * @param type $name    Name of the app_aPoll_available_polls instance to check
     * @return \PluginPollSlotViewForm 
     */
    static function checkPollConfiguration($name) {

        $form = new PluginPollSlotViewForm();
        $form->bind(array('poll' => $name));

        return $form;
    }

    static function getPollFormName($name) {

        $conf = self::getPollConfiguration($name);

        return $conf['form'];
    }

    /**
     * Returns the view template partial to display the poll form.
     *    The template can be defined in two ways:
     *    - In app_aPoll_view_default_template, to set an overall template for all polls
     *    - In In app_aPoll_available_polls_XXX_view_template, where XXX 
     *      is the name of this poll, to override the default display template
     * 
     * @param array() $poll  : the poll definition as defined in app_aPoll_available_polls
     */
    static function getPollViewTemplate($name) {
        
        $conf = self::getPollConfiguration($name);

        if (isset($conf['view_template'])) {
            $template = $conf['view_template'];
        } else {
            $template = sfConfig::get('app_aPoll_view_default_template', 'aPollSlot/default_form_view');
        }

        return $template;
    }

    /**
     * Returns the action treating the form sumbission of the given poll.
     *  The action can be defined in two ways:
     *   - In app_aPoll_view_submit_action, to set an overall action for all polls
     *   - In In app_aPoll_available_polls_XXX_submit_action, where XXX 
     *     is the name of this poll, to override the default action
     * 
     * 
     * @param array() $name : the poll identifier as defined in app_aPoll_available_polls
     */
    static function getPollSubmitAction($name) {

        $conf = self::getPollConfiguration($name);
        
        if (isset($conf['submit_action'])) {
            $action = $conf['submit_action'];
        } else {
            $action = sfConfig::get('app_aPoll_view_default_submit_action', '@a_poll_slot_submit_form');
        }

        return $action;
    }
    
    
    /**
     * Returns the configuration of poll "$name" from app_aPoll_available_polls
     * 
     * @param string $name  Name of the poll
     * @return array        Poll configuration array 
     */
    static function getPollConfiguration($name) {

        $conf = sfConfig::get('app_aPoll_available_polls');
        
        
        return $conf[$name];
    }

}

