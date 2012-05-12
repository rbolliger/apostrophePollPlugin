# Chapter 4: polls definition

## Introduction

As explained in chapter 2, a poll is a set of files. In particular, a poll is composed by a form class and some templates and actions. 

apostrophePollPlugin provides default templates and actions for rendering the form and to confirm a successful submission. Thanks to the symfony architecture, these files can be customized via configuration parameters, to fit the specific requirement of each poll.

The poll configuration parameters are based on a cascade architecture. When looking for a parameter, the plugin will look at:

1.   Poll's parameters
2.   Global parameters
3.   Plugin default parameters

So, one can define global parameters, valid for all polls published on the website and then override them with specific values for each poll. If nothing is defined for a given parameter, apostrophePollPlugin will provide a default value.

## Parameters storage

Global and poll-specific parameters are defined in `config/aPoll.yml`. 

The plugin already provides an `aPoll.yml` file in `plugins/apostrophePollPlugin/config`. You can add additional parameters or override some of the existing ones by creating a new `apps/frontend/config/aPoll.yml` file. 

Notice that the file is loaded with a cascading strategy and is environment-aware, as explained in the [symfony reference book](http://www.symfony-project.org/reference/1_4/en/03-Configuration-Files-Principles "Symfony reference book - chapter 3").

## Global parameters

This section presents the global parameters. Values displayed in the example code are the default values provided by the plugin.

### Form view

The `view` field defines parameters related to the form display and submission.
	
	# apps/frontend/config/aPoll.yml
	all:
	    settings:
	        view:
		        default_template: aPollSlot/default_form_view
		        default_submit_action: '@a_poll_slot_submit_form'
		        default_submit_success_template: aPollSlot/default_submit_success


* **`default_template`**: defines the partial template that renders the form. 
* **`default_submit_action`**: defines the action that handles the form submission. Can be defined as module/action or as a route name.
* **`default_submit_success_template`**: defines the default template rendered when the poll submission is successful. This template is only called by the default submit action. If a custom action is defined, the user must create a new template.

### Submissions

This section defines if a poll may be submitted several consecutive times by the same user. 

	# apps/frontend/config/aPoll.yml
	all:
		settings:
		    submissions:
				allow_multiple: false
				cookie_name: aPoll_submissions
				cookie_lifetime: 86400

* **`allow_multiple`**: if set to `true`, the poll is displayed every time the user reloads the page. If set to `false`, the poll is not displayed for a given time delay (see next parameters).
* **`cookie_name`**: a cookie is created in order to register user submissions. This parameter defines the name of the cookie.
* **`cookie_lifetime`**: defines the time delay between two consecutive poll submissions, when `allow_multiple` is set to false. This parameter is defined in seconds.

### Captcha

To avoid spamming and unwanted submissions, it is often useful to display a security mechanism. Captchas are a common solution. apostrophePollPlugin provides support for displaying [reCaptcha](http://www.google.com/recaptcha). A strategy to replace reCaptcha with another widget is explained below.

	# apps/frontend/config/aPoll.yml
	all:
		settings:
		    captcha:
				do_display: true

* **`do_display`**: defines if a captcha shall be displayed with the form.

#### Custom Captcha
 
To display reCaptcha, the plugin requires the installation of [sfFormExtraPlugin](http://www.symfony-project.org/plugins/sfFormExtraPlugin "sfFormExtra"). apostrophePollPlugin extends the widget provided by sfFormExtraPlugin in order to enable reCaptcha display in Ajax-driven partials, which is the case for the aPollSlot.

To use another captcha or any other security technique, it is possible to override the `getCaptchaWidget()` and `getCaptchaValidator()` functions provided by `PluginaPollBaseForm`. This can be done by customizing `aPollBaseForm`, if you want to replace reCaptcha in all polls, or directly in the poll's form class, to use a specific captcha for that particular case.




### Notifications

After a poll has been successfully submitted, it is possible to send an email notification to a give address, in order for the site administrator (or someone else) to know that something happens on the website.

	# apps/frontend/config/aPoll.yml
	all:
		settings:
		    notifications:
				do_send: true
				to: admin
				from: admin
				title_partial: aPollSlot/email_title
				body_partial: aPollSlot/email_body

* **`do_send`**: defines if a notification shall be sent after a successful poll submission.
* **`to`**: defines the email address or the username of the person who shall receive the notification.
* **`from`**: defines the email address or the username of the person actually sending the notification.
* **`title_partial`**: defines the partial rendering the email title.
* **`body_partial`**: defines the partial rendering the email body.


## Polls parameters

### Listing available polls

In order to let apostrophePollPlugin know that a poll is available, the user has to declare it in the `available_polls` field.
This declaration represents a poll template, that might be used several times in the website. Read more about poll publishing in chapter 5.

The following code must be used to declare the poll:

	# apps/frontend/config/aPoll.yml
	all:
		settings:
		    available_polls:
			   ...
			   contact:
			       name: Contact form
			       form: aPollContactForm
			   ...

Where:

* **`available_polls`** is the placeholder for listing all available polls.
* **`contact`** is the identifier of a poll. It must be unique.
* **`name`** is the name of a poll, which will be shown in a dropdown menu in the polls administration module.
* **`form`** is the form class associated to the poll.

`name` and `form` are required to define a poll. Other parameters allowing one to customize the form submissions and rendering, are described in the next section.

### Poll customization parameters

The following code shows the complete set of parameters defining the poll rendering and the form handling. The values displayed are the default values set by apostrophePollPlugin.

	# apps/frontend/config/aPoll.yml
	all:
		settings:
		    available_polls:
			contact:
				name: (required, no default value)
				form: (required, no default value)
				view_template: aPollSlot/default_form_view
				submit_action: '@a_poll_slot_submit_form'
				submit_success_template: aPollSlot/default_submit_success
				send_notification: true 
				send_to: admin
				send_from: admin 
				email_title_partial: aPollSlot/email_title
				email_body_partial: aPollSlot/email_body
				captcha_do_display: true
				reports: ~
	    

Where:

* **`name`**: Name of the poll
* **`form`**: name of the form to display. The form must extend aPollBaseForm (see chap. 4) and must be placed in a lib directory in order to be found by symfony
* **`view_template`**: defines the partial used to render the form.
* **`submit_action`**: defines the action that handles the form submission.
* **`submit_success_template`**: partial rendering the poll submission success message.
* **`send_notification`**: defines if a notification must be sent to an email address when someone submits an answer.
* **`send_to`**: email address or registered user (username) who will receive the email notification.
* **`send_from`**: defines the sender (email or user) of the notification.
* **`email_title_partial`**: name of the partial rendering the title of the email.
* **`email_body_partial`**: name of the partial rendering  the body of the email.
* **`captcha_do_display`**: shall a captcha be displayed in order to protect form submissions from spam?
* **`reports`**: list of available reports for this poll (see chapter 6). To define them, use the keywords defined in `app_aPoll_reports`. To enable all generic reports, use "`~`". You can also add poll-specific reports. Ex.: `[~, myReport, anotherReport]`. 

### Adding polls from other plugins

Thanks to the cascading configuration technique, it is possible to build the configuration of apostrophePollPlugin from multiple sources. This is particularly interesting for the definition of available polls. Indeed, this list may be built from multiple plugins and from the local project. 

Addind new poll templates is as simple as defining the required form class and templates and by creating a `aPoll.yml` configuration file in the plugin or in the app config folder.

A major advantage of the use of the `aPoll.yml` configuration file is that this allows to increase the number of poll templates shared with the community without needing to update the plugin content. This will speed up the release cycle of new polls and reduce the plugin's maintenance.


