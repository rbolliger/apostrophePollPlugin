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

            $this->poll_form = new $conf[$type]['form']();
        }
    }

}
