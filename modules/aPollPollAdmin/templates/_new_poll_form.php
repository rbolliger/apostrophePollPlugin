<form class="a-poll-admin-new-form" method="post" action="#" id="a-poll-admin-new-form">
    <div class="a-form-row a-hidden">
        <?php echo $form->renderHiddenFields() ?>
    </div>
    <div class="a-form-row title">
        <div class="a-form-field">
            <?php echo $form['title']->render(array('class' => 'big')) ?>
        </div>
        <?php echo $form['title']->renderError() ?>		
    </div>
    <div class="a-form-row">
        <ul class="a-ui a-controls">
            <li><?php echo a_anchor_submit_button(a_('Create'), array('a-show-busy')) ?></li>
            <li><?php echo a_js_button(a_('Cancel'), array('icon', 'a-cancel', 'a-options-cancel', 'alt')) ?></li>
        </ul>
    </div>
</form>

<?php a_js_call('aPollSubmitForm(?)', array(
            'form' => '#a-poll-admin-new-form',
            'container' => '#a-poll-admin-new-form-container',
            'url' => url_for('aPollPollAdmin/newWithTitle'),
        ));
?>
<?php a_js_call('apostrophe.menuToggle(?)', array('button' => '.a-poll-new-poll-button', 'classname' => 'a-options-open', 'overlay' => false, 'focus' => '#a_poll_new_poll_title')) ?>	
<?php a_js_call('apostrophe.selfLabel(?)', array('selector' => '#a_poll_new_poll_title', 'title' => a_('Title'), 'persistentLabel' => true)) ?>
