<?php use_helper('a', 'Date') ?>

<?php include_partial('a/simpleEditWithVariants', array('pageid' => $pageid, 'name' => $name, 'permid' => $permid, 'slot' => $slot)) ?>

<?php if (!$show_poll && $editable) : ?>
    <?php include_partial('aPollSlot/poll_not_displayed_debug', array('poll' => $poll)); ?>
<?php endif; ?>

<?php if ($show_poll) : ?>

    <?php // Checking if the values retrieved from app_aPoll_available_polls are valid. ?>
    <?php if (!$poll_validation->isValid() && $poll_validation->getValue('poll') != '') : ?>
        <?php include_partial('aPollSlot/poll_validation_debug', array('poll_validation' => $poll_validation)); ?>
    <?php endif; ?>

    <?php // we display the form ?>
    <?php if ($poll_validation->isValid()) : ?>

        <div id="a-poll-slot-<?php echo $poll->getSlug(); ?>" class="a-poll-slot-<?php echo $poll->getSlug(); ?> clearfix">
            <?php
            include_partial($form_view_template, array(
                'poll' => $poll,
                'form' => $poll_form,
                'action' => $submit_action,
                'pageid' => $pageid,
                'name' => $name,
                'permid' => $permid,
                'slot' => $slot
            ));
            ?> 

        </div>

    <?php endif; ?>

<?php endif; ?>