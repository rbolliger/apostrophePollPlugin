<?php use_helper('a'); ?>

<hr />
<h2 class="a-poll-preview-header"><?php echo a_('Poll preview'); ?></h2>


<?php if (!$poll_validation->isValid()) : ?>
    <h3><?php echo a_('Configuration errors in app.yml'); ?></h3>

    <?php include_partial('aPollSlot/poll_validation_debug', array('poll_validation' => $poll_validation)); ?>
<?php endif; ?>


<?php if ($poll_validation->isValid()) : ?>
    <h3><?php echo a_('Poll settings as defined in app.yml'); ?></h3>


    <?php include_partial('aPollPollAdmin/poll_settings', array('poll' => $poll)); ?>
<?php endif; ?>