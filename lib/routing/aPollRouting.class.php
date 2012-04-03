<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aPollRouting
 *
 * @author Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
class aPollRouting extends sfPatternRouting {

    static public function listenToRoutingAdminLoadConfigurationEvent(sfEvent $event) {
        $r = $event->getSubject();
        $enabledModules = array_flip(sfConfig::get('sf_enabled_modules', array()));
        if (isset($enabledModules['aPollPollAdmin'])) {

            $r->prependRoute('a_poll_poll_admin', new sfDoctrineRouteCollection(array('name' => 'a_poll_poll_admin',
                        'model' => 'aPollPoll',
                        'module' => 'aPollPollAdmin',
                        'prefix_path' => 'admin/polls',
                        'column' => 'id',
                        'with_wildcard_routes' => true)));

            $r->prependRoute('a_poll_poll_admin_new_complete', new sfDoctrineRoute('/admin/polls/new_complete/:id', array(
                        'module' => 'aPollPollAdmin',
                        'action' => 'newComplete',
                            ), array(
                        
                            ), array(
                        'model' => 'aPollPollNew',
                        'type' => 'object',
                    )));
        }
    }

}

