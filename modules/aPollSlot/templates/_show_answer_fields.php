<div class="a-admin-form-container">
    <div id="a-fieldset-<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>" class="fieldset">
        <?php if ('NONE' != $fieldset): ?>
            <h2><?php echo __($fieldset, array(), 'apostrophe') ?></h2>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th><?php echo a_('Field'); ?></th>
                    <th><?php echo a_('Value'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($form->getFieldsToSave() as $name): ?>

                    <?php $field = $form[$name]; ?>
                    <?php $value = $form[$name]->getValue(); ?>
                    <?php $type = gettype($value); ?>

                    <tr class="<?php echo 'a-form-row a-admin-' . strtolower($type) . ' a-admin-form-field-' . $name ?>">

                        <td class="a-form-label"><?php echo $form->getWidget($name)->getLabel() ? $form->getWidget($name)->getLabel() : $name ?></td>

                        <td class="a-form-field">
                            <?php
                            echo aPollToolkit::renderFormFieldValue(
                                    $form, $field instanceof sfOutputEscaper ? $field->getRawValue() : $field, $value
                            );
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>