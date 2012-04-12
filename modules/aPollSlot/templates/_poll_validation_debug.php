
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

