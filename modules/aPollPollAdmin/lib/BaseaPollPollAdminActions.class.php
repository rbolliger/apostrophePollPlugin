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
    $this->form = new aPollPollNewPollForm();
    $this->form->bind($request->getParameter('a_poll_poll_new_poll'));
    if ($this->form->isValid())
    {
//      $this->a_blog_post = new aBlogPost();
//      $this->a_blog_post->Author = $this->getUser()->getGuardUser();
//      $this->a_blog_post->setTitle($this->form->getValue('title'));
//      $event = new sfEvent($this->a_blog_post, 'a.postAdded', array());
//      $this->dispatcher->notify($event);
//      $this->a_blog_post->save();
      $this->postUrl = $this->generateUrl('a_poll_poll_admin_new');
//      $this->postUrl = $this->generateUrl('a_poll_poll_admin_new', $this->a_blog_post);
      return 'Success';
    }
    return 'Error';
  }
    
}
