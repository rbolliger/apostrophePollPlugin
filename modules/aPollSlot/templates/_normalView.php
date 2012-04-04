<?php use_helper('a') ?>

<?php include_partial('a/simpleEditWithVariants', array('pageid' => $pageid, 'name' => $name, 'permid' => $permid, 'slot' => $slot)) ?>


<?php // Checking if the values retrieved from app_aPoll_available_polls are valid. ?>
<?php if (!$poll_validation->isValid()) : ?>
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

    <div class="a-poll-slot-<?php echo $poll->getSlug(); ?>">
        <div class="a-ui a-poll-slot-container">

            <div class="a-poll-intro">
                <div class="a-poll-title-bar">
                    <h2 class="a-poll-title"><?php echo $poll->getTitle() ?></h2>
                </div>

                <?php if ($poll->getDescription()): ?>
                    <div class="a-poll-description">
                        <p><?php echo $poll->getDescription(); ?></p>
                    </div>
                <? endif; ?>

            </div>

            <div class="a-admin-form-container">

                <?php include_stylesheets_for_form($poll_form) ?>
                <?php include_javascripts_for_form($poll_form) ?>

                <?php echo $poll_form->renderFormTag('aPollSlot/submitViewSlot', array('id' => 'a-admin-form')); ?>

                <?php echo $poll_form; ?>

                <ul class="a-ui a-controls">
                    <li class="a-admin-action-save"> <?php echo a_anchor_submit_button(a_('Submit', array(), 'apostrophe'), array('a-save')); ?> </li>
                </ul>
                </form>
            </div>


        </div>
    </div>   
<?php endif; ?>
