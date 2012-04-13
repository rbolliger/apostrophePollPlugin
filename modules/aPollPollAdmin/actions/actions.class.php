<?php

require_once dirname(__FILE__) . '/../lib/BaseaPollPollAdminActions.class.php';

/**
 * aPollPollAdmin actions.
 * 
 * @package    aPollPlugin
 * @subpackage aPollPollAdmin
 * @author     Raffaele Bolliger <raffaele.bolliger@gmail.com>
 */
class aPollPollAdminActions extends BaseaPollPollAdminActions {

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

}
