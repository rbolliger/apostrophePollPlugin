# Chapter 4: polls definition

## Introduction

As explained in chapter 2, a poll is a set of files. In particular, a poll is composed by a form class, plus some templates. apostrophePollPlugin already provides default templates for rendering the form and to confirm a successful submission. Thanks to the configuration parameters, it is possible to customize them to fit the poll's specific needs.

The poll configuration parameters are based on a cascade architecture. When looking for a parameter, the plugin will look at:

1.   Poll's parameters
2.   Global parameters
3.   Plugin default parameters

So, one can define global parameters, valid for all polls published on the website and then override them with specific values for each poll. If nothing is defined for a given parameter, apostrophePollPlugin will provide a default value.

Global and poll-specific parameters are defined in app.yml. For a complete example, you can look at the app.yml.template file provided with the plugin. All the parameters available for the plugin are stored in the `aPoll` field.



## Global parameters

In this section, global parameters are presented. The values displayed in the exaple code are the default values provided by the plugin.

### Form view

The `view` field defines parameters related to the form display and submission.

	aPoll:
	    view:
		default_template: aPollSlot/default_form_view
		default_submit_action: '@a_poll_slot_submit_form'
		default_submit_success_template: aPollSlot/default_submit_success


* **`default_template`**: defines the template that renders the form. 
* **`default_submit_action`**: defines the action that handles the form submission. Can be defined as module/action or as a route name.
* **`default_submit_success_template`**: defines the default template rendered when the poll submission is successful.

### Submissions

This section defines if a poll may be submitted several consecutive times by the same user. 

	aPoll:
	    submissions:
		allow_multiple: false
		cookie_name: aPoll_submissions
		cookie_lifetime: 86400

* **`allow_multiple`**: if set to `true`, the poll is displayed every time the user reloads the page. If set to `false`, the poll is not displayed for a given time delay (see next parameters).
* **`cookie_name`**: a cookie is created in order to register user submissions. This parameter defines the name of the cookie.
* **`cookie_lifetime`**: defines the time delay between two consecutive poll submissions, when `allow_multiple` is set to false. This parameter is defined in seconds.

### Captcha

To avoid spamming and unwanted submissions, it is ofter useful to display a security mechanism. Captchas are a common solution. apostrophePollPlugin provides support for displaying [reCaptcha](http://www.google.com/recaptcha). A mechanism to replace reCaptcha with another widget is explained in chapter 6.

	aPoll:
	    captcha:
		do_display: true

* **`do_display`**: defines if a captcha shall be displayed with the form.

### Notifications

After a poll has been successfully submitted, it is possible to send an email notification to a give address, in order for the site administrator (or someone else) to know that something happens on the website.

	aPoll:
	    notifications:
			do_send: true
			to: admin
			from: admin
			title_partial: aPollSlot/email_title
			body_partial: aPollSlot/email_body

* **`do_send`**: defines if a notification shall be sent after a successufll poll submission.
* **`to`**: defines the email address or the username of the person who shall receive the notification.
* **`from`**: defines the email address or the username of the person actually sending the notification.
* **`title_partial`**: defines the partial rendering the email title.
* **`body_partial`**: defines the partial rendering the email body.


### Reports

apostrpohePollPlugin allows one to export user's answers in various file formts. By default excel and CSV are available. Other export types may be added using the following configuration parameters. For example to define excel export format, we use these parameters:

![export feature](images/export.png "Export feature")


	aPoll:  
	   reports:  
	      excel:  
		  label: Export to excel     
		  action: aPollPollAdmin/exportToExcel  
		  is_generic: true  


where:

* **`excel`**: is the identifier of the report.
* **`label`**: is the label, which will be rendered as link to the report.
* **`action`**: is the action which renders the report.
* **`is_generic`**: defines if this report can be applied to any poll (true) or if it can only be applied to specific polls.

The `is_generic` field is used to define which reports might be proposed by default to export data. If a report is poll-specific, it must be explicitely defined in the poll configuration (see below) in order to appear as export option.

## Polls parameters

### Listing available polls

As explained in chapter 2, polls are defined as a set of templates and a form class. To let apostrophePollPlugin know that they are available for publishing, they must be declared explicitely in app.yml using the following code:

	aPoll:
	    available_polls:
		   contact:
		       name: Contact form
		       form: aPollContactForm

Where:

* **`available_polls`** is the placeholder for listing all available polls.
* **`contact`** is the identifier of a poll. It must be unique.
* **`name`** is the name of a poll, which will be shown in a dropdown menu in aPollPollAdmin module.
* **`form`** is the form class associated to the poll.

`name` and `form` are required to define a poll. Other parameters allowing one to customize the form submissions and rendering, are described in the next section.

In fact, this structure represents poll templates, which might or not be published in the website. Read more about poll publishing in chapter 5.

### Poll customization parameters

The following code shows the complete set of parameters defining the poll rendering and the form handling. The values displayed are the default values set by apostrophePollPlugin.

	aPoll:
	    available_polls:
		contact:
			name: required, no default value
			form: required, no default value
			view_template: aPollSlot/default_form_view
			submit_action: '@a_poll_slot_submit_form'
			submit_success_template: aPollSlot/default_submit_success
			send_notification: true (inherited from global params)
			send_to: admin (inherited from global params)
			send_from: admin (inherited from global params)
			email_title_partial: aPollSlot/email_title (inherited from global params)
			email_body_partial: aPollSlot/email_body (inherited from global params)
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
* **`reports`**: list of available reports for this poll. To define them, use the keywords defiled in `app_aPoll_reports`. To enable all generic reports, use `~`. You can then add poll-specific reports. Ex.: `[~, myReport, anotherReport]`.
