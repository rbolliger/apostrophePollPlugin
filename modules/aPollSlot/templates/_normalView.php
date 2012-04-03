<?php use_helper('a') ?>

<?php include_partial('a/simpleEditWithVariants', array('pageid' => $pageid, 'name' => $name, 'permid' => $permid, 'slot' => $slot)) ?>

<?php if (!$poll_form->isValid()) : ?>
    <div class="a-form-row">
        
        <p><?php echo a_("Some problems have been detected in the poll definition:"); ?></p>
        <div class="a-form-errors">
            
            <ul class="a-ui a-error-list error_list">
                <?php if ($poll_form->hasGlobalErrors()) : ?>
                    <?php $poll_form->renderGlobalErrors(); ?>
                <? endif; ?>

                <?php foreach ($poll_form as $field) : ?>

                    <?php if ($field->hasError()) : ?>
                        <li><?php echo $field->renderError(); ?></li>
                    <?php endif ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <p><?php echo a_("Please, review your app.yml definition in order to display this poll."); ?></p>
    </div>
<?php endif ?>

<?php if (isset($values['text'])): ?>
    <h4><?php echo htmlspecialchars($values['text']) ?></h4>
<?php endif; ?>
