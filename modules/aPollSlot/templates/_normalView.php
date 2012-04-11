<?php use_helper('a') ?>

<?php include_partial('a/simpleEditWithVariants', array('pageid' => $pageid, 'name' => $name, 'permid' => $permid, 'slot' => $slot)) ?>

<?php if (!$show_poll && $editable) : ?>
    <div class="a-poll-nodisplay-help">
        <?php echo a_('The poll is not visible for two possible reasons:'); ?>
        <ul>
            <li><?php echo a_('Publication dates: see parameters set in polls admin'); ?></li>
            <li><?php echo a_('You already submitted an answer and the poll is configured to not display twice. (see app.yml)'); ?></li>
        </ul>
    </div>
<?php endif; ?>

<?php if ($show_poll) : ?>

    <?php // Checking if the values retrieved from app_aPoll_available_polls are valid. ?>
    <?php if (!$poll_validation->isValid() && $poll_validation->getValue('poll') != '') : ?>
        <div class="a-form-row">

            <p><?php echo a_("Some problems have been detected in the poll definition:"); ?></p>
            <div class="a-form-errors">

                <ul class="a-ui a-error-list error_list">
                    <?php if ($poll_validation->hasGlobalErrors()) : ?>
                        <?php $poll_validation->renderGlobalErrors(); ?>
                    <? endif; ?>

                    <?php foreach ($poll_validation as $field) : ?>

                        <?php if ($field->hasError()) : ?>
                            <li><?php echo $field->renderError(); ?></li>
                        <?php endif ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <p><?php echo a_("Please, review your app.yml definition in order to display this poll."); ?></p>
        </div>
    <?php endif ?>


    <?php // we display the form ?>
    <?php if ($poll_validation->isValid()) : ?>

        <div id="a-poll-slot-<?php echo $poll->getSlug(); ?>" class="a-poll-slot-<?php echo $poll->getSlug(); ?>">
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