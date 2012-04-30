# Chapter 6 - Plugin customization


## Custom Captcha
 
apostrophePollPlugin provides support for displaying reCaptcha. This requires the installation of [sfFormExtraPlugin](http://www.symfony-project.org/plugins/sfFormExtraPlugin "sfFormExtra"). apostrophePollPlugin extends the widget provided by sfFormExtraPlugin in order to enable reCaptcha display in ajax-driven partials, which is the case for the aPollSlot.

To use another captcha or any other security technique, it is possible to override the `getCaptchaWidget()` and `getCaptchaValidator()` functions provided by `PluginaPollBaseForm`. This can be done by customizing `aPollBaseForm`, if you want to replace reCaptcha in all polls, or directly in the poll's form class, to use a specific captcha for that particular case.



