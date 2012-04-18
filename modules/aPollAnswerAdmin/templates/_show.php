<?php foreach ($configuration->getFormFields($form_answer, $form_answer->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
    <?php

    include_partial('aPollAnswerAdmin/show_answer', array(
        'a_poll_answer' => $a_poll_answer,
        'form' => $form_answer,
        'configuration' => $configuration,
        'helper' => $helper,
        'fieldset' => 'Submission',
        'fields' => $fields,
    ));
    ?>
<?php endforeach; ?>


<?php

include_partial('aPollAnswerAdmin/show_answer_fields', array(
    'a_poll_answer' => $a_poll_answer,
    'form' => $form_poll,
    'fieldset' => 'Answers',
));
?>


