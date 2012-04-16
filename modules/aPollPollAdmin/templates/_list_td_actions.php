<td>
  <ul class="a-ui a-admin-td-actions">
    <?php echo $helper->linkToEdit($a_poll_poll, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($a_poll_poll, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
      <?php echo $helper->linkToListAnswers($a_poll_poll, array(  'params' =>   array(  ))) ?>
  </ul>
</td>
