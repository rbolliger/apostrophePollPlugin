<?php use_helper('a') ?>

<?php include_partial('a/simpleEditWithVariants', array('pageid' => $pageid, 'name' => $name, 'permid' => $permid, 'slot' => $slot)) ?>


    <div class="a-ui a-poll-slot-container success">
        <?php include_partial($template, array('poll' => $poll, 'form' => $poll_form)); ?>  
    </div>




