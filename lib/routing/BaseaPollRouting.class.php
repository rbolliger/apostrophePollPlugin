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
class BaseaPollRouting extends sfPatternRouting {

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

            $r->prependRoute('a_poll_poll_admin_preview_poll', new sfRoute('/admin/polls/preview/', array(
                        'module' => 'aPollPollAdmin',
                        'action' => 'previewPoll',
                            ),
                            array(
                                'sf_method' => array('post'),
                    )));
            
             $r->prependRoute('a_poll_poll_admin_export_to_excel', new sfDoctrineRoute('/admin/polls/export-excel/:id', array(
                        'module' => 'aPollPollAdmin',
                        'action' => 'exportToExcel',
                            ), array(
                            ), array(
                        'model' => 'aPollPoll',
                        'type' => 'object',
                        'method' => 'getByIdWithAnswers',
                    )));
            
        }


        if (isset($enabledModules['aPollAnswerAdmin'])) {



            $r->prependRoute('a_poll_answer_admin', new sfDoctrineRouteCollection(array(
                        'name' => 'a_poll_answer_admin',
                        'model' => 'aPollAnswer',
                        'module' => 'aPollAnswerAdmin',
                        'prefix_path' => 'admin/answers',
                        'column' => 'id',
                        'with_wildcard_routes' => true,
                        'actions' => array('delete','list','edit','show'),  // edit must be left, otherwise the list won't be rendered
                        'with_show' => true,
                        'model_methods' => array(
                            'object' => 'getByIdWithFieldsAndPoll'
                        ),
                )));

            $r->prependRoute('a_poll_answer_admin_list_by_poll', new sfRoute('/admin/answers/poll/:id', array(
                        'module' => 'aPollAnswerAdmin',
                        'action' => 'listByPoll',
                            ),
                            array(
                                'sf_method' => array('get','head'),
                                'id'   => '\d+',
                    )));
        }


        if (isset($enabledModules['aPollSlot'])) {

            $r->prependRoute('a_poll_slot_submit_form', new sfRoute('/admin/polls/submit_form',
                            array(
                                'module' => 'aPollSlot',
                                'action' => 'submitPollForm',
                            ),
                            array(
                                'sf_method' => array('post'),
                            )
            ));
        }
    }

}

