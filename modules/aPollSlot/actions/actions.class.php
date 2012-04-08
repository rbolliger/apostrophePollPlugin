<?php

class aPollSlotActions extends aSlotActions {

    public function executeEdit(sfRequest $request) {
        $this->editSetup();

        // Hyphen between slot and form to please our CSS
        $value = $this->getRequestParameter('slot-form-' . $this->id);
        $this->form = new aPollSlotEditForm($this->id, array());
        $this->form->bind($value);
        if ($this->form->isValid()) {
            // Serializes all of the values returned by the form into the 'value' column of the slot.
            // This is only one of many ways to save data in a slot. You can use custom columns,
            // including foreign key relationships (see schema.yml), or save a single text value 
            // directly in 'value'. serialize() and unserialize() are very useful here and much
            // faster than extra columns

            $values = $this->form->getValues();

            // saving the reference to the poll
            $this->slot->setPollId($values['poll']);

            unset($values['poll']);

            $this->slot->setArrayValue($values);

            return $this->editSave();
        } else {
            // Makes $this->form available to the next iteration of the
            // edit view so that validation errors can be seen, if any
            return $this->editRetry();
        }
    }

    public function executeSubmitPollForm(sfRequest $request) {

        $values = $request->getParameter('a-poll-form');


        $this->poll = Doctrine_Core::getTable('aPollPoll')->findOneById($values['poll_id']);
        $this->forward404Unless($this->poll);

        // validating app_aPoll_available_polls entry
        $this->poll_validation = aPollToolkit::checkPollConfiguration($this->poll->getType());

        // Creation of variables needed to render the partials
        $values = $request->getParameter('a-poll-form');

        $this->page = aPageTable::retrieveByIdWithSlots($values['pageid']);

        $this->slot = $this->page->getSlot(
                $values['slot_name'], $values['permid']);

        $type = $this->poll->getType();

        $show_poll = aPollToolkit::checkIfShowPoll($request, $this->poll);


        $form_name = aPollToolkit::getPollFormName($type);

        $this->poll_form = new $form_name(array(
                    'poll_id' => $values['poll_id'],
                    'slot_name' => $values['slot_name'],
                    'permid' => $values['permid'],
                    'pageid' => $values['pageid'],
                    'remote_address' => $this->getRequest()->getRemoteAddress(),
                ));

        $partial_vars = array(
            "name" => $values['slot_name'],
            "type" => 'aPoll',
            "permid" => $values['permid'],
            "pageid" => $values['pageid'],
            "slot" => $this->slot,
            "updating" => $this->updating,
            "options" => $this->options,
            "poll_validation" => $this->poll_validation,
            "form_view_template" => aPollToolkit::getPollViewTemplate($type),
            "submit_action" => aPollToolkit::getPollSubmitAction($type),
            "poll" => $this->poll,
            "poll_form" => $this->poll_form,
            "show_poll" => $show_poll,
        );


        if ($this->poll_validation->isValid()) {

            $this->poll_form->bind($values);

            if ($this->poll_form->isValid()) {

                $answer = $this->poll_form->save();
                
                // sends a notification email
                aPollToolkit::sendNotificationEmail($type, $this->getMailer(), $this->poll, $answer);

                return $this->renderPartial($this->getModuleName() . '/submit_success', array_merge($partial_vars, array('template' => aPollToolkit::getPollSubmitSuccessTemplate($type))));
            }


            return $this->renderPartial($this->getModuleName() . '/normalView', $partial_vars);
        }
    }

    protected function getVariablesForSlot(sfRequest $request, aPollPoll $poll) {
        
    }

}

