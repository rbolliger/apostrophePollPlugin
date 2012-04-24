<?php

/**
 * Description of aPollToolkit
 *
 * @author Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
class BaseaPollToolkit {

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
    static function getPollAllowMultipleSubmissions(aPollPoll $poll) {

        if ((true === $poll->getSubmissionsAllowMultiple()) || (false === $poll->getSubmissionsAllowMultiple())) {
            return $poll->getSubmissionsAllowMultiple();
        }

        return self::getValueFromGlobalConf('app_aPoll_submissions', 'allow_multiple', false);
    }

    /**
     * Returns the lifetime of the multiple submission option expressed in seconds.
     * 
     * @param type $name   The poll identifier as defined in app_aPoll_available_polls
     * @return integer     Lifetime of the multiple submission option, in seconds 
     * @see getPollAllowMultipleSubmissions()
     */
    static function getCookieLifetime(aPollPoll $poll) {

        if ($poll->getSubmissionsDelay()) {
            $delay = $poll->getSubmissionsDelay(); 

            list($h, $m, $s) = explode(':', $delay);
            return ($h * 3600) + ($m * 60) + $s;
        }

        return self::getValueFromGlobalConf('app_aPoll_submissions', 'cookie_lifetime', 86400);
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
     * @param type $name The poll identifier as defined in app_aPoll_available_polls
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

    static function getCaptchaDoDisplay($name) {
        return self::getValueFromConf($name, 'captcha_do_display', 'app_aPoll_captcha', 'do_display', true);
    }

    /**
     * Returns true if at least one report is available for this poll. Returns
     * false if reports are explicitely disabled.
     * 
     * @param type $name The poll identifier as defined in app_aPoll_available_polls
     * @return boolean 
     */
    static function hasReports($name) {

        $conf = self::getPollConfiguration($name);

        if (!isset($conf['reports'])) {
            return true;
        }

        return false == $conf['reports'] ? false : true;
    }

    /**
     * Returns an array containing the settings for a given report. If the report
     * is not found in app_aPoll_reports, the function returns false.
     * 
     * @param type $report Identifier of the report
     * @return array or false 
     */
    static function getReportSettings($report) {

        return self::getValueFromGlobalConf('app_aPoll_reports', $report, false);
    }

    /**
     * Retrieves all settings for all reports defined for a given poll.
     * 
     * 
     * @param type $name The poll identifier as defined in app_aPoll_available_polls
     * @return array Reports settigns 
     */
    static function getPollReports($name) {

        // trying to get reorts defined in the poll configuration
        $conf = self::getPollConfiguration($name);

        $reports = isset($conf['reports']) ? $conf['reports'] : false;


        // if nothing is defined, we return all the global reports available
        if ($reports === false) {
            return self::getGeneralReports();
        }

        // if any is defined, we parse them and recover all settings
        $settings = array();

        // ensuring that $reports is ana rray
        if (is_string($reports)) {
            $reports = array($reports);
        }

        // looping over all reports to recover their settings
        foreach ($reports as $report) {

            if ('~' === $report) {
                $settings = array_merge($settings, self::getGeneralReports());
            } else {
                $settings = array_merge($settings, array($report => self::getReportSettings($report)));
            }
        }

        return $settings;
    }

    static function getGeneralReports() {

        // retrieving all reports
        $conf = sfConfig::get('app_aPoll_reports', false);

        if (false === $conf) {
            return $false;
        }

        $general = array();

        foreach ($conf as $key => $report) {

            // if the report is specific to a particular poll (i.e. not generic), we skip it
            if (isset($report['is_generic']) && !$report['is_generic']) {
                continue;
            }

            $general = array_merge($general, array($key => $report));
        }

        return $general;
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

            $answer = self::getValueFromGlobalConf($global_root, $global_field, $default);
        }

        return $answer;
    }

    static protected function getValueFromGlobalConf($root, $field, $default) {

        $conf = sfConfig::get($root, array());

        return isset($conf[$field]) ? $conf[$field] : $default;
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

        $cookie = self::getCookieContent($request);

        $content = (isset($cookie[$slug])) ? $cookie[$slug] : array('show' => true, 'timeout' => time() + self::getCookieLifetime($poll));

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

        $cookie = self::getCookieContent($request);

        if (!(($value === true) || ($value === false))) {

            throw new sfException(__FUNCTION__ . ' only accepts "true" and "false" as values.');
        }


        $cookie = array_merge($cookie, array($slug => array('show' => $value, 'timeout' => time() + self::getCookieLifetime($poll))));

        $response->setCookie(self::getCookieName(), self::encodeForCookie($cookie), time() + self::getCookieLifetime($poll));
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
            throw new sfException('No destination email defined. Cannot send a notification.');
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

    /**
     * Renders the value of an admin-generator field in function of its type. This function is 
     * meant to render a "show" representation of a form field.
     * 
     * @param sfFormField $field: form field to render
     * @param mixed $value: the value to render
     * @return string 
     */
    static public function renderAdminFieldValue(sfForm $form, sfModelGeneratorConfigurationField $field, $value = null) {

        if (null === $value) {
            return '';
        }

        if ($renderer = $field->getRenderer()) {
            return call_user_func_array($renderer, array_merge(array($value), $field->getRendererArguments()));
        }

        $string = self::renderField($form, $field, $value, $field->getType());


        return $string;
    }

    static function renderFormFieldValue(sfForm $form, sfFormField $field, $value = null) {

        if (null === $value) {
            return '';
        }

        if ($field->getWidget() instanceof sfWidgetFormChoiceBase) {
            $type = 'sfWidgetFormChoice';
        } elseif (true === $value || false === $value) {
            $type = 'Boolean';
        } elseif (false !== strtotime($value)) {
            $type = 'Date';
        } else {
            $type = 'String';
        }

        $string = self::renderField($form, $field, $value, $type);


        return $string;
    }

    static protected function renderField($form, $field, $value, $type) {

        if (self::is_serialized($value)) {

            $value = @unserialize($value);

        }

        if (is_array($value)) {

            $array = array();
            foreach ($value as $v) {
                $array[] = self::doRenderField($form, $field, $v, $type);
            }

            $string = implode(', ', $array);
        } else {
            $string = self::doRenderField($form, $field, $value, $type);
        }

        return $string;
    }

    static protected function doRenderField($form, $field, $value, $type) {


        switch ($type) {
            case 'Date':

                sfContext::getInstance()->getConfiguration()->loadHelpers('Date');

                $format = $field instanceof sfModelGeneratorConfigurationField ? $field->getConfig('date_format', 'f') : 'f';
                
                $string = false !== strtotime($value) ? format_date($value, $format) : '&nbsp;';
                break;

            case 'Boolean':
                $string = get_partial('aPollAnswer/list_field_boolean', array('value' => $value));
                break;

            case 'ForeignKey':
            case 'sfWidgetFormChoice':
                $widget = $form[$field->getName()]->getWidget();

                if ($widget instanceof sfWidgetFormChoice) {
                    $choices = $widget->getChoices();

                    $string = $choices[$value];
                } else {
                    $string = $value;
                }

                break;

            default:
                $string = $value;
        }

        return $string;
    }

    /**
     * Checks if a value is serialized. Taken from http://www.cs278.org/blog/2009/10/23/php-function-is_serialized/
     * 
     * @param type $val
     * @return boolean 
     */
    static public function is_serialized($val) {
        if (!is_string($val)) {
            return false;
        }
        if (trim($val) == "") {
            return false;
        }
        if (preg_match("/^(i|s|a|o|d):(.*);/si", $val)) {
            return true;
        }
        return false;
    }

}

