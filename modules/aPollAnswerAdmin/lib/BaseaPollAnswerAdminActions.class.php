<?php

require_once dirname(__FILE__) . '/../lib/aPollAnswerAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/aPollAnswerAdminGeneratorHelper.class.php';

/**
 * Base actions for the aPollPlugin aPollAnswerAdmin module.
 * 
 * @package     aPollPlugin
 * @subpackage  aPollAnswerAdmin
 * @author      Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
abstract class BaseaPollAnswerAdminActions extends autoaPollAnswerAdminActions {

    // the route must be active, so we kill here any attempt to edit an answer
    public function executeEdit(sfWebRequest $request) {
        $this->forward404();
    }

    public function executeShow(sfWebRequest $request) {

        $this->a_poll_answer = $this->getRoute()->getObject();



        $this->form_answer = $this->configuration->getForm($this->a_poll_answer);

        $poll = $this->a_poll_answer->getPoll();
        $form_name = aPollToolkit::getPollFormName($poll->getType());
        
        $fields = $this->a_poll_answer->getFields();
        $values = array();
        foreach ($fields as $field) {
            $values = array_merge($values, array($field->getName() => $field->getValue())); 
        }
        
        $this->form_poll = new $form_name($values);
    }

    public function executeListByPoll(sfWebRequest $request) {

        $this->setFilters(array_merge($this->getFilters(), array('poll_id' => $request->getParameter('id'))));

        $this->dispatcher->connect('admin.build_query', array($this, 'listenToBuildQuery'));

        $this->executeIndex($request);

        $this->setTemplate('index');
    }

    public static function listenToBuildQuery(sfEvent $event, Doctrine_Query $query) {

        $subject = $event->getSubject();
        $root = $query->getRootAlias();

        return $query->addWhere($root . '.poll_id = ?', $subject->getRequestParameter('id'));
    }

    public function executeFilter(sfWebRequest $request) {
        $this->setPage(1);

        if ($request->hasParameter('_reset')) {
            $this->setFilters($this->configuration->getFilterDefaults());

            $this->redirect('@a_poll_answer_admin_list_by_poll?id=' . $this->filters->getValue('poll_id'));
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());

        $this->filters->bind($request->getParameter($this->filters->getName()));
        if ($this->filters->isValid()) {
            $this->setFilters($this->filters->getValues());

            $this->redirect('@a_poll_answer_admin_list_by_poll?id=' . $this->filters->getValue('poll_id'));
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this->setTemplate('index');
    }

}
