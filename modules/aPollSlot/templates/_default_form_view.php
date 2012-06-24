<?php use_helper('a', 'JavascriptBase') ?>


<div class="a-poll-slot-container">

    <div class="a-poll-title-bar">
        <<?php echo $ht = aPollToolkit::getPollHeadingTag($poll->getType()); ?> class="a-poll-title"><?php echo $poll->getTitle() ?></<?php echo $ht; ?>>
    </div>

    <?php if ($poll->getDescription()): ?>
        <div class="a-poll-description">
            <div><?php echo html_entity_decode($poll->getDescription()); ?></div>
        </div>
    <? endif; ?>


    <div class="a-admin-form-container">

        <?php include_stylesheets_for_form($form) ?>
        <?php include_javascripts_for_form($form) ?>


        <form method="post" action="#" id="a-poll-form-<?php echo $poll->getId(); ?>">

            <?php //echo $form->renderFormTag(url_for($action))  ?>

            <?php echo $form->renderHiddenFields() ?>

            <?php if ($form->hasGlobalErrors()): ?>
                <?php echo $form->renderGlobalErrors() ?>
            <?php endif; ?>

            <?php foreach ($form as $row) : ?>
                <?php echo $row->isHidden() ? '' : $row->renderRow(); ?>
            <?php endforeach; ?>

            <ul class="a-ui a-controls">
                <li class="a-admin-action-save"><input type="submit" value="<?php echo a_('Submit') ?>" class="a-btn a-show-busy"></li>
            </ul>
        </form>
        
        <?php
        a_js_call('aPollSubmitPollForm(?)', array(
            'form' => '#a-poll-form-' . $poll->getId(),
            'container' => '#a-slot-content-' . $pageid . '-' . $name . '-' . $permid,
            'url' => url_for($action),
        ));
        ?>

    </div>


</div>   