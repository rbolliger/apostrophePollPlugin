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
        if (isset($enabledModules['aPollAdmin'])) {
            $r->prependRoute('a_poll_admin', new sfDoctrineRouteCollection(array('name' => 'a_poll_admin',
                        'model' => 'aPollPoll',
                        'module' => 'aPollAdmin',
                        'prefix_path' => 'admin/polls',
                        'column' => 'id',
                        'with_wildcard_routes' => true)));
        }
    }

}

