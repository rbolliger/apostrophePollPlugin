<div class="a-poll-nodisplay-help">
    <h3>Poll "<?php echo $poll->getTitle(); ?>"</h3>
    <p><?php echo a_('The poll is not visible for two possible reasons:'); ?></p>
    <ul>
        <li><?php echo a_('Publication dates (see parameters set in %link%)', array('%link%' => link_to('poll\'s admin', '@a_poll_poll_admin_edit?id=' . $poll->getId()))); ?></li>
        <ul>
            <li><?php echo a_('Server time:') ?> <?php echo format_datetime(time()); ?></li>
            <li><?php echo a_('Publication dates: from %date_from% to %date_to%',array(
                '%date_from%' => $poll->getPublishedFrom() ? format_datetime($poll->getPublishedFrom()) : 'unlimited',
                '%date_to%' => $poll->getPublishedTo() ? format_datetime($poll->getPublishedTo()) : 'unlimited',
            )); ?></li>
        </ul>
        <li><?php echo a_('You already submitted an answer and the poll is configured to not display twice. (see app.yml)'); ?></li>
        <ul>
            <li><?php echo a_('Setting: %setting%', array('%setting%' => true == aPollToolkit::getPollAllowMultipleSubmissions($poll->getType()) ? a_('Multiple submissions allowed') : a_('Only one answer allowed'))); ?></li>
        </ul>
    </ul>
</div>