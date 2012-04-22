<?php

require_once dirname(__FILE__) . '/../lib/aPollPollAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/aPollPollAdminGeneratorHelper.class.php';

/**
 * Base actions for the aPollPlugin aPollPollAdmin module.
 * 
 * @package     aPollPlugin
 * @subpackage  aPollPollAdmin
 * @author      Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
abstract class BaseaPollPollAdminActions extends autoaPollPollAdminActions {

    // You must create with at least a title
    public function executeNew(sfWebRequest $request) {
        $this->forward404();
    }

    // Doctrine collection routes make it a pain to change the settings
    // of the standard routes fundamentally, so we provide another route
    public function executeNewWithTitle(sfWebRequest $request) {
        $this->form = new aPollPollNewForm();
        $this->form->bind($request->getParameter('a_poll_poll_new'));
        if ($this->form->isValid()) {

            $this->form->save();

            $this->postUrl = $this->generateUrl('a_poll_poll_admin_new_complete', $this->form->getObject());

            return 'Success';
        }
        return 'Error';
    }

    public function executeNewComplete(sfWebRequest $request) {
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

    public function executePreviewPoll(sfWebRequest $request) {


        $this->poll_values = $request->getParameter('a_poll_poll');

        $name = $this->poll_values['type'];

        $this->poll_validation = aPollToolkit::checkPollConfiguration($name);

        $culture = $this->getUser()->getCulture();

        // filling data required to preview the poll
        $this->poll = new aPollPoll();
        $this->poll->setTitle($this->poll_values[$culture]['title']);
        $this->poll->setDescription($this->poll_values[$culture]['description']);

        $form = aPollToolkit::getPollFormName($name);
        $this->form = new $form();

        $this->form_view_template = aPollToolkit::getPollViewTemplate($name);
        $this->submit_action = aPollToolkit::getPollSubmitAction($name);

        // some fake values, just to call the form partial
        $this->pageid = 1;
        $this->name = 'dfsd';
        $this->permid = 1;
    }

    public function executeListAnswers(sfWebRequest $request) {

        $this->redirect('@a_poll_answer_admin_list_by_poll?id=' . $request->getParameter('id'));
    }

    public function executeUpdate(sfWebRequest $request) {

        $this->a_poll_poll = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->a_poll_poll);
        
        $params = $request->getParameter($this->form->getName());

        // updating cookie to ensure thath changes done in multiple submissions choice are applied
        aPollToolkit::setShowPollToCookie($request, $this->getResponse(), $this->a_poll_poll, (bool) $params['submissions_allow_multiple']);

        parent::executeUpdate($request);
    }
    
    public function executeExportToExcel(sfWebRequest $request) {
        
        
        
        

        $this->poll = $this->getRoute()->getObject();
        
    }

}
