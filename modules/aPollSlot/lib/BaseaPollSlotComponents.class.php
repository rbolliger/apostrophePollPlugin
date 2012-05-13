<?php
/*
 * This file is part of the apostrophePollPlugin package.
 * (c) 2012 Raffaele Bolliger <raffaele.bolliger@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class BaseaPollSlotComponents extends aSlotComponents {

    public function executeEditView() {
        // Must be at the start of both view components
        $this->setup();

        // Careful, don't clobber a form object provided to us with validation errors
        // from an earlier pass
        if (!isset($this->form)) {
            $this->form = new aPollSlotEditForm($this->id, $this->slot->getArrayValue());
        }
    }

    public function executeNormalView() {
        $this->setup();

        $this->poll = $this->slot->getPoll();
        $type = $this->poll->getType();
        
        
        if (!$this->show_poll = aPollToolkit::checkIfShowPoll($this->getRequest(), $this->poll)) {
         
            return 'Success';
            
        }
        

        // validating apoll_settings_available_polls entry
        $this->poll_validation = aPollToolkit::checkPollConfiguration($type);


        if ($this->poll_validation->isValid()) {



            $form_name = aPollToolkit::getPollFormName($type);
            $this->poll_form = new $form_name(array(
                        'poll_id' => $this->poll->getId(),
                        'slot_name' => $this->name,
                        'permid' => $this->permid,
                        'pageid' => $this->pageid,
                        'remote_address' => $this->getRequest()->getRemoteAddress(),
                        'culture' => $this->getUser()->getCulture(),
                        'poll_type' => $type,
                    ));
            

            // Getting view template partial to display the form.
            // The template can be defined in two ways:
            // - In apoll_settings_view_default_template, to set an overall template for all polls
            // - In In apoll_settings_available_polls_XXX_view_template, where XXX 
            //    is the name of this poll, to override the default display template
            $this->form_view_template = aPollToolkit::getPollViewTemplate($type);


            // Getting the action treating the form sumbission.
            // The action can be defined in two ways:
            // - In apoll_settings_view_submit_action, to set an overall action for all polls
            // - In In apoll_settings_available_polls_XXX_submit_action, where XXX 
            //    is the name of this poll, to override the default action
            $this->submit_action = aPollToolkit::getPollSubmitAction($type);
        }
    }

}
