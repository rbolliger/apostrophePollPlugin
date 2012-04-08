<?php use_helper('a'); ?>

<h1><?php echo a_('New Poll submission'); ?></h1>

<p>
<?php

echo a_('Poll "name" has a new submission from IP address ip at date', array(
    'name' => $poll->getTitle(),
    'ip' => $answer->getRemoteAddress(),
    'date' => $answer->getCreatedAt(),
));
?>
</p>


<p><?php echo a_('To have a look at the submitted values, click here.'); ?></p>

<p><?php echo a_('To administer the poll, click url', array('url' => link_to('here',url_for('@a_poll_poll_admin',array('absolute' => true))))); ?></p>

