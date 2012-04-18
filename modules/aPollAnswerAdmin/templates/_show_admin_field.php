

<?php if ($field->isPartial()): ?>
    <?php include_partial('aPollAnswerAdmin/' . $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
    <?php include_component('aPollAnswerAdmin', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
    <div class="<?php echo $class ?>">
        <div class="a-form-label"><?php echo $label ? $label : ($form->getWidget($name)->getLabel() ? $form->getWidget($name)->getLabel() : $name) ?></div>

        <div class="a-form-field">
            <?php echo aPollToolkit::renderAdminFieldValue($form, $field instanceof sfOutputEscaper ? $field->getRawValue() : $field, $form[$name]->getValue()); ?>
        </div>
    </div>

<?php endif; ?>

