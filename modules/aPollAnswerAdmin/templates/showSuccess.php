<?php use_helper('a', 'Date') ?>
<?php include_partial('aPollAnswerAdmin/assets') ?>

<?php slot('a-subnav') ?>
<div class="a-ui a-subnav-wrapper admin">
	<div class="a-subnav-inner">
		<?php include_partial('aPollAnswerAdmin/form_header', array('a_poll_answer' => $a_poll_answer, 'form' => $form, 'configuration' => $configuration)) ?>
	</div>	
</div>
<?php end_slot() ?>

<div class="a-ui a-admin-container <?php echo $sf_params->get('module') ?>">
  <?php include_partial('aPollAnswerAdmin/form_bar', array('title' => __('Edit APollAnswerAdmin', array(), 'apostrophe'))) ?>

  <div class="a-admin-content main">
	  <?php include_partial('aPollAnswerAdmin/flashes') ?>
 		<?php include_partial('aPollAnswerAdmin/form', array('a_poll_answer' => $a_poll_answer, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div class="a-admin-footer">
 		<?php include_partial('aPollAnswerAdmin/form_footer', array('a_poll_answer' => $a_poll_answer, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

</div>
