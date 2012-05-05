<?php use_helper('a'); ?>

<hr />
<h2 class="a-poll-preview-header"><?php echo a_('Poll preview'); ?></h2>


<?php if (!$poll_validation->isValid()) : ?>
    <div class="a-poll-preview-validation-debug clearfix">
        <h3><?php echo a_('Configuration errors in app.yml'); ?></h3>

        <?php include_partial('aPollSlot/poll_validation_debug', array('poll_validation' => $poll_validation)); ?>
    </div>
<?php endif; ?>


<?php if ($poll_validation->isValid()) : ?>
    <div class="a-poll-preview-settings clearfix">
        <h3><?php echo a_('Poll settings as defined in app.yml'); ?></h3>

        <?php include_partial('aPollPollAdmin/poll_settings', array('poll' => $poll_values)); ?>
    </div>

    <div class="a-poll-preview-poll clearfix">
        <h3><?php echo a_('Preview'); ?></h3>


        <div class="a-slots clearfix">
            <div class="a-slot a-normal aPoll clearfix">
                <div class="a-slot-content clearfix" id="<?php echo sprintf('a-slot-content-%s-%s-%s', $pageid, $name, $permid); ?>">
                    <div class="a-poll-slot-<?php echo $poll->getId(); ?>">
                        <?php
                        include_partial($form_view_template, array(
                            'pageid' => $pageid,
                            'permid' => $permid,
                            'name' => $name,
                            'poll' => $poll,
                            'form' => $form,
                            'action' => $submit_action,
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php a_js_call('aPollPreviewHideSubmitButton(?)', array('button' => '#a-poll-form-' . $poll->getId() . ' ul.a-controls')) ?>
    <?php include_partial('a/globalJavascripts') ?>

<?php endif; ?>