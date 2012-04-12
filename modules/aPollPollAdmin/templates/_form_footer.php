<?php use_helper('a') ?>
<?php a_js_call('aMultipleSelectAll(?)', array('choose-one' => a_('Select to Add'))) ?>


<div class="a-poll-preview-area" id="a-poll-preview-area"></div>


<?php
a_js_call('aPollPreviewPoll(?)', array(
    'url' => a_url('aPollPollAdmin', 'previewPoll', array('id' => $a_poll_poll->getId())),
    'form' => '#a-admin-form',
    'container' => '#a-poll-preview-area',
    'button' => '#preview-poll-button'
))
?>
  