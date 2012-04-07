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

        return self::getValueFromConf($name, 'view_template', 'app_aPoll_view', 'default_template', 'aPollSlot/default_form_view');

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

        return self::getValueFromConf($name, 'submit_action', 'app_aPoll_view', 'default_submit_action', '@a_poll_slot_submit_form');
    }

    /**
     * Returns the configuration of poll "$name" from app_aPoll_available_polls
     * 
     * @param string $name  the poll identifier as defined in app_aPoll_available_polls
     * @return array        Poll configuration array 
     */
    static function getPollConfiguration($name) {

        $conf = sfConfig::get('app_aPoll_available_polls');

        if (!isset($conf[$name])) {
            throw new sfException('No poll with identifier "' . $name . '" is defined in app_aPoll_available_polls.');
        }


        return $conf[$name];
    }

    /**
     * Returns the name of the template to be used to display a message after the poll
     * has been successfully submitted.
     * 
     * @param type $name   The poll identifier as defined in app_aPoll_available_polls
     * @return string      The name of the template to render
     */
    static function getPollSubmitSuccessTemplate($name) {

        return self::getValueFromConf($name, 'submit_success_template', 'app_aPoll_view', 'default_submit_success_template', 'aPollSlot/default_submit_success');
    }

    static function getPollAllowMultipleSubmissions($name) {

        return self::getValueFromConf($name, 'allow_multiple_submissions', 'app_aPoll_submission', 'allow_multiple', false);
    }

    static function getCookieLifetime($name) {

        return self::getValueFromConf($name, 'cookie_lifetime', 'app_aPoll_submission', 'cookie_lifetime', 86400);
    }

    static protected function getValueFromConf($name, $local_field, $global_root, $global_field, $default) {

        $conf = self::getPollConfiguration($name);

        if (isset($conf[$local_field])) {
            $answer = $conf[$local_field];
        } else {

            $conf = sfConfig::get($global_root, array());

            $answer = isset($conf[$global_field]) ? $conf[$global_field] : $default;
        }

        return $answer;
    }

    /**
     * Checks if a poll can be displayed. The function looks if the poll can be 
     * displayed with respect to publication dates and previous user submissions.
     * 
     * @param type $slug
     * @param sfWebRequest $request
     * @return type 
     */
    static function checkIfShowPoll(sfWebRequest $request, aPollPoll $poll) {

        return self::checkIfShowPollByCookie($poll, $request) && self::checkIfShowPollByDates($poll, $request);
    }

    static protected function checkIfShowPollByCookie(aPollPoll $poll, sfWebRequest $request) {

        $slug = $poll->getSlug();
        $type = $poll->getType();

        $cookie = self::getCookieContent($request);

        $content = (isset($cookie[$slug])) ? $cookie[$slug] : array('show' => true, 'timeout' => time() + self::getCookieLifetime($type));

        if (true === $content['show'] || time() > $content['timeout']) {

            return true;
        } else {

            return false;
        }
    }

    static protected function checkIfShowPollByDates(aPollPoll $poll, sfWebRequest $request) {


        // TODO
        return true;
    }

    static function setShowPollToCookie(sfWebRequest $request, sfWebResponse $response, aPollPoll $poll, $value) {

        $slug = $poll->getSlug();
        $type = $poll->getType();

        $cookie = self::getCookieContent($request);

        if (!(($value === true) || ($value === false))) {

            throw new sfException(__FUNCTION__ . ' only accepts "true" and "false" as values.');
        }

        $cookie = array_merge($cookie, array($slug => array('show' => $value, 'timeout' => time() + sfConfig::get('app_aPoll_submission_cookie_lifetime', 86400))));

        $response->setCookie(self::getCookieName(), self::encodeForCookie($cookie), time() + self::getCookieLifetime($type));
    }

    static function getCookieName() {

        $conf = sfConfig::get('app_aPoll_submission');
        
        return isset($conf['cookie_name']) ? $conf['cookie_name'] : 'aPoll_submission';
    }

    static function getCookieContent(sfWebRequest $request) {

        $cookie = $request->getCookie(self::getCookieName());

        return (null !== $cookie) ? self::decodeFromCookie($cookie) : array();
    }

    static protected function encodeForCookie($array) {

        $cookie = '';
        foreach ($array as $name => $poll) {
            $text = implode('...', array($name, $poll['show'] ? 'true' : 'false', $poll['timeout']));

            $cookie .= $text . '---';
        }

        return $cookie;
    }

    static protected function decodeFromCookie($cookie) {


        $polls = explode('---', $cookie);

        $array = array();
        foreach ($polls as $poll) {

            $values = explode('...', $poll);

            if (count($values) < 3) {
                continue;
            }

            $v = array($values[0] => array('show' => $values[1] === 'true' ? true : false, 'timeout' => $values[2]));

            $array = array_merge($array, $v);
        }

        return $array;
    }

}

