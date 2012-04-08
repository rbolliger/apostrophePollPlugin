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

    /**
     * Returns the name of the form to render for poll $name
     * 
     * @param type $name    Name of the poll, as defined in app_aPoll_available_polls
     * @return strung       The name of the form 
     */
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

    /**
     * Tells if a poll shall be displayed after that a user has already submitted 
     * an answer. This option is linked to a timeout.
     * 
     * @param type $name   The poll identifier as defined in app_aPoll_available_polls
     * @return bool         
     * @see getCookieLifetime()
     */
    static function getPollAllowMultipleSubmissions($name) {

        return self::getValueFromConf($name, 'allow_multiple_submissions', 'app_aPoll_submission', 'allow_multiple', false);
    }

    /**
     * Returns the lifetime of the multiple submission option expressed in seconds.
     * 
     * @param type $name   The poll identifier as defined in app_aPoll_available_polls
     * @return integer     Lifetime of the multiple submission option, in seconds 
     * @see getPollAllowMultipleSubmissions()
     */
    static function getCookieLifetime($name) {

        return self::getValueFromConf($name, 'cookie_lifetime', 'app_aPoll_submission', 'cookie_lifetime', 86400);
    }

    /**
     * Tells if a notification must be sent to an email address after that a user has submitted a poll answer.
     * 
     * @param type $name
     * @return bool
     */
    static function getSendNotification($name) {

        return self::getValueFromConf($name, 'send_notification', 'app_aPoll_notifications', 'do_send', true);
    }

    /**
     * Returns the email address where the submission notification is sent to.
     * 
     * @param type $name
     * @return type 
     */
    static function getNotificationEmailTo($name) {

        return self::getValueFromConf($name, 'send_to', 'app_aPoll_notifications', 'to', 'admin');
    }

    static function getNotificationEmailFrom($name) {

        return self::getValueFromConf($name, 'send_from', 'app_aPoll_notifications', 'from', 'admin');
    }

    static function getNotificationEmailTitlePartial($name) {
        return self::getValueFromConf($name, 'email_title_partial', 'app_aPoll_notifications', 'title_partial', 'aPollSlot/email_title');
    }

    static function getNotificationEmailBodyPartial($name) {
        return self::getValueFromConf($name, 'email_body_partial', 'app_aPoll_notifications', 'body_partial', 'aPollSlot/email_body');
    }

    /**
     * Returns the value of a given option defined for poll $name. The function looks 
     * for a setting in the poll configuration, then in the global configuration and
     * finally, sends a default value.
     * 
     * @param type $name            The poll identifier as defined in app_aPoll_available_polls
     * @param type $local_field     Name of the options defined in the poll configuration
     * @param type $global_root     Name of the root field (e.g. app_aPoll_submissions) defined in 
     *                              the global configuration
     * @param type $global_field    Name of the options defined in the global configuration
     * @param type $default         Default value, if nothing else found
     * @return mixed                The value of the requested option    
     */
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

    /**
     *  Checks if a poll shall be displayed by looking if a cookie has been saved.
     *  If the cookie exist, the function returns its value.
     * 
     * @param aPollPoll $poll       The poll instance
     * @param sfWebRequest $request The web request
     * @return boolean 
     */
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

    /**
     * Checks if a poll shall be displayed by comparing the actual date with the
     * poll's publication dates.
     * 
     * @param aPollPoll $poll
     * @param sfWebRequest $request
     * @return boolean 
     */
    static protected function checkIfShowPollByDates(aPollPoll $poll, sfWebRequest $request) {


        $now = time();

        $start = strtotime($poll->getPublishedFrom());
        $end = strtotime($poll->getPublishedTo());

        // if $end is defined and the publication end is old, we don't display
        if (null != $end && $now > $end) {
            return false;
        }

        // if $start is defined and we are toot early, we don't display
        if (null != $start && $now < $start) {
            return false;
        }

        return true;
    }

    /**
     *  Saves the visibility option of a poll in a cookie.
     * 
     * @param sfWebRequest $request
     * @param sfWebResponse $response
     * @param aPollPoll $poll
     * @param type $value
     * @throws sfException 
     */
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

    /**
     * Returns the name of the cookie used to store poll's visibility.
     * 
     * @return type 
     */
    static function getCookieName() {

        $conf = sfConfig::get('app_aPoll_submission');

        return isset($conf['cookie_name']) ? $conf['cookie_name'] : 'aPoll_submission';
    }

    /**
     * Reads the poll's visibility cookie and returns its value.
     * 
     * @param sfWebRequest $request
     * @return type 
     */
    static function getCookieContent(sfWebRequest $request) {

        $cookie = $request->getCookie(self::getCookieName());

        return (null !== $cookie) ? self::decodeFromCookie($cookie) : array();
    }

    /**
     * Encodes an array in order to be saved ina cookie, which only accepts strings
     * 
     * @param type $array
     * @return string 
     */
    static protected function encodeForCookie($array) {

        $cookie = '';
        foreach ($array as $name => $poll) {
            $text = implode('...', array($name, $poll['show'] ? 'true' : 'false', $poll['timeout']));

            $cookie .= $text . '---';
        }

        return $cookie;
    }

    /**
     * Decodes a cookie content and returns an array
     * 
     * @param type $cookie
     * @return type 
     */
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

    /**
     * Checks if $value is a valid email or if is a valid user. Returns null if none of them.
     * 
     * @param type $value
     * @return null|string 
     */
    static function isUserOrEmail($value, $returnEmail = false) {

        $val = new sfValidatorEmail();

        try {

            $val->clean($value);

            return $returnEmail ? $value : 'email';
        } catch (Exception $exc) {

            $val = new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'column' => 'username'));

            try {

                $val->clean($value);

                if ($returnEmail) {
                    $user = Doctrine_Core::getTable('sfGuardUser')->findOneByUsername($value);

                    return $user->getEmailAddress();
                }

                return 'user';
            } catch (Exception $exc) {

                return false;
            }
        }
    }

    static function sendNotificationEmail($name, sfMailer $mailer, aPollPoll $poll, aPollAnswer $answer) {

        if (!self::getSendNotification($name)) {
            return false;
        }


        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');

        $from = self::isUserOrEmail(self::getNotificationEmailFrom($name), true);
        $to = self::isUserOrEmail(self::getNotificationEmailTo($name), true);
        
        if (is_null($to)) {
            throw new sfException('No email defined. Cannot send a notification.');
        }

        $arguments = array(
            'poll' => $poll,
            'answer' => $answer,
        );


        $message = $mailer->compose(
                $from, $to);
        
        $message->setContentType("text/html");


        $message->setSubject(get_partial(self::getNotificationEmailTitlePartial($name), $arguments));



        $message->setBody(get_partial(self::getNotificationEmailBodyPartial($name), $arguments));

        $mailer->send($message);

        return true;
    }

}

