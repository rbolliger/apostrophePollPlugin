<td>
    <ul class="a-ui a-admin-td-actions">
        <?php echo $helper->linkToEdit($a_poll_poll, array('params' => array(), 'class_suffix' => 'edit', 'label' => 'Edit',)) ?>
        <?php echo $helper->linkToDelete($a_poll_poll, array('params' => array(), 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete',)) ?>
        <?php echo $helper->linkToListAnswers($a_poll_poll, array('params' => array())) ?>

        <?php if(aPollToolkit::hasReports($a_poll_poll->getType())): ?>
        
        <li class="a-options-container a-admin-action-export-answers">
            <?php echo a_button(
                    '<span class="icon"></span>' . __('Reports', array(), 'apostrophe'),
                    '#',
                    array('class' => 'icon no-label a-options-button a-poll-export-answers'),
                    'a-poll-export-answers-'.$a_poll_poll->getId()
                    ) ?>
            <ul class="a-ui a-options a-poll-admin-export-answers-ajax dropshadow clearfix">
                <?php include_component('aPollPollAdmin', 'exportAnswers', array('poll' => $a_poll_poll)) ?>
            </ul>
        </li>
        <?php endif; ?>
    </ul>
</td>
