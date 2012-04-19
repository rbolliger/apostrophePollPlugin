<div class="a-admin-form-container">
    <div id="a-fieldset-<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>" class="fieldset">
        <?php if ('NONE' != $fieldset): ?>
            <h2><?php echo __($fieldset, array(), 'apostrophe') ?></h2>
        <?php endif; ?>

        <?php foreach ($form->getFieldsToSave() as $name): ?>
            
            <?php $field = $form[$name]; ?>
            <?php $value = $form[$name]->getValue(); ?>
            <?php $type = gettype($value); ?>
            
            <div class="<?php echo 'a-form-row a-admin-' . strtolower($type) . ' a-admin-form-field-' . $name ?>">
                
                <div class="a-form-label"><?php echo $form->getWidget($name)->getLabel() ? $form->getWidget($name)->getLabel() : $name ?></div>

                <div class="a-form-field">
                    <?php echo aPollToolkit::renderFormFieldValue(
                            $form,
                            $field instanceof sfOutputEscaper ? $field->getRawValue() : $field,
                            aPollToolkit::is_serialized($value) ? implode(', ' ,unserialize($value)) : $value
                            ); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>