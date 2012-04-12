<?php use_helper('a'); ?>

<hr />
<h2 class="a-poll-preview-header"><?php echo a_('Poll preview'); ?></h2>

<h3><?php echo a_('Poll settings as defined in app.yml'); ?></h3>
    
    <p><?php echo a_('Here are the settings defined in app.yml. They are a mix of what has been defined for the poll itself, and settings inherited from global parameters.'); ?></p>
    
    
    <?php $name = $poll['type']; ?>
    <dl>
        <dt><?php echo a_('Form'); ?></dt>
        <dd><?php echo aPollToolkit::getPollFormName($name); ?></dd>
        
        <dt><?php echo a_('Form render template (view_template)'); ?></dt>
        <dd><?php echo aPollToolkit::getPollViewTemplate($name); ?></dd>
        
        <dt><?php echo a_('Submit action'); ?></dt>
        <dd><?php echo aPollToolkit::getPollSubmitAction($name); ?></dd>
        
        <dt><?php echo a_('Submit success template'); ?></dt>
        <dd><?php echo aPollToolkit::getPollSubmitSuccessTemplate($name); ?></dd>
        
        <dt><?php echo a_('Multiple submissions'); ?></dt>
        <dd><?php echo aPollToolkit::getPollAllowMultipleSubmissions($name) == true ? a_('Allowed') : a_('Only one submission'); ?></dd>
        
        <dt><?php echo a_('Submissions delay (if multiple not allowed)'); ?></dt>
        <dd><?php echo aPollToolkit::getCookieLifetime($name); ?></dd>
        
        <dt><?php echo a_('Send notification?'); ?></dt>
        <dd><?php echo aPollToolkit::getSendNotification($name) == true ? a_('Yes') : a_('No'); ?></dd>
        
        <dt><?php echo a_('Send to'); ?></dt>
        <dd><?php echo aPollToolkit::getNotificationEmailTo($name); ?></dd>
        
        <dt><?php echo a_('Send from'); ?></dt>
        <dd><?php echo aPollToolkit::getNotificationEmailFrom($name); ?></dd>
        
        <dt><?php echo a_('Email title template'); ?></dt>
        <dd><?php echo aPollToolkit::getNotificationEmailTitlePartial($name); ?></dd>
        
        <dt><?php echo a_('Email body template'); ?></dt>
        <dd><?php echo aPollToolkit::getNotificationEmailBodyPartial($name); ?></dd>
        
        <dt><?php echo a_('Display a security captcha?'); ?></dt>
        <dd><?php echo aPollToolkit::getCaptchaDoDisplay($name) == true ? a_('Yes') : a_('No'); ?></dd>
        
    </dl>