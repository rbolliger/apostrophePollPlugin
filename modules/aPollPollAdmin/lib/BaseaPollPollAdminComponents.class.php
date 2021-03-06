<?php
/*
 * This file is part of the apostrophePollPlugin package.
 * (c) 2012 Raffaele Bolliger <raffaele.bolliger@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Base actions for the aPollPlugin aPollPollAdmin module.
 * 
 * @package     apostrophePollPlugin
 * @subpackage  aPollPollAdmin
 * @author     Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
abstract class BaseaPollPollAdminComponents extends sfComponents
{
    
  public function executeExportAnswers()
  {

      $this->reports = aPollToolkit::getPollReports($this->poll->getType());
      
  }
}