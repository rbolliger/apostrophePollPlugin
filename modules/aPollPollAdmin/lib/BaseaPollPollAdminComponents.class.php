<?php

/**
 * Base actions for the aPollPlugin aPollPollAdmin module.
 * 
 * @package     apostrophePollPlugin
 * @subpackage  aPollPollAdmin
 * @author     Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
abstract class BaseaPollPollAdminComponents extends sfComponents
{
  
  public function executeNewPoll()
  {
    $this->form = new aPollPollNewPollForm();
  }
}