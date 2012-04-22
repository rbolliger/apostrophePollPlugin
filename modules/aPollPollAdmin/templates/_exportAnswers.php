<?php use_helper('a'); ?>


<?php foreach ($reports as $key => $report) : ?>
    <li class="a-options-item"><?php
    echo a_button(__($report['label'], array(), 'apostrophe'), url_for($report['action'].'?poll_id='.$poll->getId()), array('class' => 'alt no-bg a-poll-export-' . $key)
    )
    ?>
    </li>
<?php endforeach; ?>

<?php a_js_call('apostrophe.menuToggle(?)', array('button' => '#a-poll-export-answers-' . $poll->getId(), 'classname' => 'a-options-open', 'overlay' => false)) ?>	



