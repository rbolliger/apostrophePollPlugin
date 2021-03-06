<?php
/*
 * This file is part of the apostrophePollPlugin package.
 * (c) 2012 Raffaele Bolliger <raffaele.bolliger@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * aPollPollAdmin module helper.
 *
 * @package    buddies
 * @subpackage aPollPollAdmin
 * @author     Raffaele Bolliger <raffaele.bolliger at gmail.com>
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class aPollPollAdminGeneratorHelper extends BaseaPollPollAdminGeneratorHelper {

    public function linkToPreviewPoll($object, $params) {
        return '<li class="a-admin-action-preview-poll">' . a_button(a_('<span class="icon"></span>' . 'Preview poll'), '#a-poll-preview-area', array('a-save a-btn icon a-poll-preview alt'), 'preview-poll-button', '_preview_poll') . '</li>';
    }
    
     public function linkToListAnswers($object, $params) {
    
        return '<li class="a-admin-action-list-answers">'.link_to(
                '<span class="icon"></span>'.__('List answers', array(), 'apostrophe'),
                '@a_poll_answer_admin_list_by_poll?id='.$object->getId(),
                array(
                    'class'=>'a-btn icon no-label a-poll-list-answers',
                    'title' => 'List answers')).'</li>';
  
    }
    

}
