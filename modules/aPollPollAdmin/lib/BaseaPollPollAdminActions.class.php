<?php
require_once dirname(__FILE__).'/../lib/aPollPollAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/aPollPollAdminGeneratorHelper.class.php';
/**
 * Base actions for the aPollPlugin aPollPollAdmin module.
 * 
 * @package     aPollPlugin
 * @subpackage  aPollPollAdmin
 * @author      Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
abstract class BaseaPollPollAdminActions extends autoaPollPollAdminActions
{
  

  // You must create with at least a title
  public function executeNew(sfWebRequest $request)
  {
    $this->forward404();
    
  }
  
  // Doctrine collection routes make it a pain to change the settings
  // of the standard routes fundamentally, so we provide another route
  public function executeNewWithTitle(sfWebRequest $request)
  { 
    $this->form = new aPollPollNewForm();
    $this->form->bind($request->getParameter('a_poll_poll_new'));
    if ($this->form->isValid())
    {
 
      $this->form->save();
 
      $this->postUrl = $this->generateUrl('a_poll_poll_admin_new_complete',$this->form->getObject());

      return 'Success';
    }
    return 'Error';
  }
  
   public function executeNewComplete(sfWebRequest $request)
  {
    $object = $this->getRoute()->getObject();
    
    
    $a_poll = new aPollPoll();
    $a_poll->setTitle($object->getTitle());
    $a_poll->setSlug(aTools::slugify($object->getTitle()));
    
    $this->form = $this->configuration->getForm($a_poll);
    $this->a_poll_poll = $this->form->getObject();
    
    // we don't need it anymore
    $object->delete();
    
    $this->setTemplate('new');
    
  }
    
}
