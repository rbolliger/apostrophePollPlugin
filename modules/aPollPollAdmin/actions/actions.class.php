<?php

require_once dirname(__FILE__).'/../lib/BaseaPollPollAdminActions.class.php';

/**
 * aPollPollAdmin actions.
 * 
 * @package    aPollPlugin
 * @subpackage aPollPollAdmin
 * @author     Raffaele Bolliger <raffaele.bolliger@gmail.com>
 */
class aPollPollAdminActions extends BaseaPollPollAdminActions
{
    
    public function executePreviewPoll(sfWebRequest $request) {
        
        $this->poll = $request->getParameter('a_poll_poll');
        
        print_r($this->poll);
        
    }
    
}
