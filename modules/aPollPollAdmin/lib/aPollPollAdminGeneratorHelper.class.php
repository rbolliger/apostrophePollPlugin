<?php

/**
 * aPollPollAdmin module helper.
 *
 * @package    buddies
 * @subpackage aPollPollAdmin
 * @author     Raffaele Bolliger <raffaele.bolliger at gmail.com>
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class aPollPollAdminGeneratorHelper extends BaseaPollPollAdminGeneratorHelper
{
    
     public function linkToPreviewPoll($object, $params)
  {
    return '<li class="a-admin-action-preview-poll">' . a_button(a_('<span class="icon"></span>'.'Preview poll'), '#a-poll-preview-area', array('a-save a-btn icon a-poll-preview alt'), 'preview-poll-button', '_preview_poll') . '</li>';
     }
    
}
