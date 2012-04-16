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

    // You must create with at least a title
    public function executeNew(sfWebRequest $request) {
        $this->forward404();
    }

    public function executeListByPoll(sfWebRequest $request) {

        $this->dispatcher->connect('admin.build_query', array($this, 'listenToBuildQuery'));

        $this->executeIndex($request);

        $this->setTemplate('index');
    }

    public static function listenToBuildQuery(sfEvent $event, Doctrine_Query $query) {
    
        $subject = $event->getSubject();
        $root = $query->getRootAlias();
        
        return $query->addWhere($root.'.poll_id = ?', $subject->getRequestParameter('id'));
        
    }
    

}
