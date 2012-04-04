<?php use_helper('a') ?>

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

            <?php include_stylesheets_for_form($form) ?>
            <?php include_javascripts_for_form($form) ?>

            <?php echo $form->renderFormTag(url_for($action), array('id' => 'a-admin-form')); ?>

            <?php echo $form; ?>

            <ul class="a-ui a-controls">
                <li class="a-admin-action-save"> <?php echo a_anchor_submit_button(a_('Submit', array(), 'apostrophe'), array('a-save')); ?> </li>
            </ul>
            </form>
        </div>

    </div>
</div>   