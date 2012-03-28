<?php

/**
 * apostrophePollPlugin configuration.
 * 
 * @package     apostrophePollPlugin
 * @subpackage  config
 * @author      Buddies SARL
 * @version     SVN: $Id: PluginConfiguration.class.php 17207 2009-04-10 15:36:26Z Kris.Wallsmith $
 */
class apostrophePollPluginConfiguration extends sfPluginConfiguration {

    const VERSION = '1.0.0-DEV';

    /**
     * @see sfPluginConfiguration
     */
    public function initialize() {

        // Routes for various admin modules

        if (sfConfig::get('app_a_admin_routes_register', true)) {
            $this->dispatcher->connect('routing.load_configuration', array('aPollRouting', 'listenToRoutingAdminLoadConfigurationEvent'));
        }
    }

}
