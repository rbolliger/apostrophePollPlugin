<?php

/**
 * aPollAnswerAdmin module helper.
 *
 * @package    buddies
 * @subpackage aPollAnswerAdmin
 * @author     Raffaele Bolliger <raffaele.bolliger at gmail.com>
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class aPollAnswerAdminGeneratorHelper extends BaseaPollAnswerAdminGeneratorHelper {

    public function linkToBackToPolls($params) {
        return '<li class="a-admin-action-back-to-polls">' . link_to('<span class="icon"></span>' . __($params['label'], array(), 'apostrophe'), '@a_poll_poll_admin',array("class" => "a-btn icon big a-arrow-left")) . '</li>';
    }

}
