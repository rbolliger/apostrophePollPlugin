<?php use_helper('a', 'Date'); ?>

<h1><?php echo a_('New Poll submission'); ?></h1>

<p>
    <?php
    echo a_('Poll "%name%" has a new submission from IP address %ip% at %date%.', array(
        '%name%' => $poll->getTitle(),
        '%ip%' => $answer->getRemoteAddress(),
        '%date%' => format_date($answer->getCreatedAt()),
    ));
    ?>
</p>

<p><?php echo a_('To administer the poll, click %url%.', array('%url%' => link_to(a_('here'), url_for('@a_poll_poll_admin', array('absolute' => true))))); ?></p>

<p><?php echo a_('The submitted message can be seen below, but can also be checked online %url%.', array('%url%' => link_to(a_('here'), url_for('@a_poll_answer_admin_show?id=' . $answer->getId(), array('absolute' => true))))); ?></p>


<div>
    <?php
    include_partial('aPollSlot/show_answer_fields', array(
        'a_poll_answer' => $answer,
        'form' => $poll_form,
        'fieldset' => 'Submission',
    ));
    ?>
</div>