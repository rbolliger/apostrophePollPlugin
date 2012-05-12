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

        // Once shown, we consider that an answer is no more new
        $this->a_poll_answer->setIsNew(false);
        $this->a_poll_answer->save();

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


        // There is no really great way to determine whether the filters differ from the defaults
        // do it the tedious way
        $this->filtersActive = false;

        // Without this check we crash admin gen that has no filters
        if ($this->configuration->hasFilterForm()) {
            $defaults = $this->configuration->getFilterDefaults();
            $filters = $this->getFilters();

            foreach ($filters as $key => $val) {

                // we skip poll_id field, otherwise filters are always shown
                if ('poll_id' == $key) {
                    continue;
                }

                if (isset($defaults[$key])) {
                    $this->filtersActive = true;
                } else {
                    if (!$this->isEmptyFilter($val)) {
                        $this->filtersActive = true;
                    }
                }
            }
        }


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

    protected function executeBatchSetRead(sfWebRequest $request) {
        // TBB: use collection delete rather than a delete query. This ensures
        // that the object's delete() method is called, which provides
        // for checking userHasPrivileges()

        $ids = $request->getParameter('ids');

        $items = Doctrine_Query::create()
                ->from('aPollAnswer')
                ->whereIn('id', $ids)
                ->execute();
        $count = count($items);
        $error = false;

        foreach ($items as $item) {

            try {
                $item->setIsNew(false);
                $item->save();
            } catch (Exception $e) {
                $error = true;
            }
        }


        if (($count == count($ids)) && (!$error)) {
            $this->getUser()->setFlash('notice', 'The selected items have been successfully set as read.');
        } else {
            $this->getUser()->setFlash('error', 'An error occurred while setting as read the selected items.');
        }

        $this->redirect('@a_poll_answer_admin');
    }

    public function executeIndex(sfWebRequest $request) {

        parent::executeIndex($request);


// Without this check we crash admin gen that has no filters
        if ($this->configuration->hasFilterForm()) {
            $defaults = $this->configuration->getFilterDefaults();
            $filters = $this->getFilters();

            $this->filtersActive = false;
            
            foreach ($filters as $key => $val) {
                if ($key == 'poll_id') {
                    continue;
                }

                if (isset($defaults[$key])) {
                    $this->filtersActive = true;
                } else {
                    if (!$this->isEmptyFilter($val)) {
                        $this->filtersActive = true;
                    }
                }
            }
        }
    }

}
