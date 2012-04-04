<?php

class aPollSlotComponents extends aSlotComponents {

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
        $this->values = $this->slot->getArrayValue();
        
        $this->poll = $this->slot->getPoll();
        $type = $this->poll->getType();

        // validating app_aPoll_available_polls entry
        $this->poll_validation = new PluginPollSlotViewForm($this->id);
        $this->poll_validation->bind(array('poll' => $type));


        if ($this->poll_validation->isValid()) {
            
            $conf = sfConfig::get('app_aPoll_available_polls');
            $poll_conf = $conf[$type];

            $this->poll_form = new $poll_conf['form']();
            
            
            // Getting view template partial to display the form.
            // The template can be defined in two ways:
            // - In app_aPoll_view_default_template, to set an overall template for all polls
            // - In In app_aPoll_available_polls_XXX_view_template, where XXX 
            //    is the name of this poll, to override the default display template
            if (isset($poll_conf['view_template'])) {
                $this->form_view_template = $poll_conf['view_template'];
            } else {
                $this->form_view_template = sfConfig::get('app_aPoll_view_default_template',$this->getModuleName().'/default_form_view');
            }
            
            // Getting the action treating the form sumbission.
            // The action can be defined in two ways:
            // - In app_aPoll_view_submit_action, to set an overall action for all polls
            // - In In app_aPoll_available_polls_XXX_submit_action, where XXX 
            //    is the name of this poll, to override the default action
            if (isset($poll_conf['submit_action'])) {
                $this->submit_action = $poll_conf['submit_action'];
            } else {
                $this->submit_action = sfConfig::get('app_aPoll_view_default_submit_action','@a_poll_slot_submit_form');
            }
            
        }
    }

}
