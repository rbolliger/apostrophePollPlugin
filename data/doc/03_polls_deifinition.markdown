# Chapter 3: polls definition

## Introduction

As explained in chapter 2, a poll is a set of files. In particular, a poll is composed by a form class, plus some templates. apostrophePollPlugin already provides default templates for rendering the form and to confirm a successful submission. Thanks to the configuration parameters, it is possible to customize them to fit the poll's specific needs.

The poll configuration parameters are based on a cascade architecture. When looking for a parameter, the plugin will look at:
  1.   Poll's parameters
  2.   Global parameters
  3.   Plugin default parameters

So, one can define global parameters, valid for all polls published on the website and then override them with specific values for each poll. If nothing is defined for a given parameter, apostrophePollPlugin will provide a default value.

Global and poll-spicific parameters are defined in app.yml. For a complete example, you can look at the app.yml.template file provided with the plugin. All the parameters available for the plugin are stored in the `aPoll` field.



## Global parameters

### Form view

The `view` field defines parameters related to the form display and submission.

* **`app_aPoll_view_default_template`**: defines the template that renders the form. Default value: `aPollSlot/default_form_view`
* **`app_aPoll_view_default_submit_action`**: defines the action that handles the form submission. Default value: `@a_poll_slot_submit_form`
* **`app_aPoll_view_default_submit_success_template`**: defines the default template rendered when the poll submission is successful. Default value: `aPollSlot/default_submit_success`.

### Submissions

This section defines if a poll may be submitted several consecutive times by the same user. 

* **`app_aPoll_submissions_allow_multiple`**: if set to true, the poll is displayed every time the user reloads the page. If set to false, the poll is not displayed for a given time delay (see next parameters). Default value: `false`.
* **`app_aPoll_submissions_cookie_name`**: a cookie is created in order to register user submissions. This parameter defines the name of the cookie. Default value: `aPoll_submission`.
* **`app_aPoll_submissions_cookie_lifetime`**: defines the time delay between two consecutive poll submissions, when `app_aPoll_submissions_allow_multiple` is set to false. This parameter is defined in seconds. Default value: `86400`.

### Captcha

To avoid spamming and unwanted submissions, it is ofter useful to display a security mechanism. Captchas are a common solution. apostrophePollPlugin provides support for displaying [reCaptcha](http://www.google.com/recaptcha). A mechanism to replace reCaptcha with another widget is explained later.

* **`app_aPoll_submissions_do_display`**: defines if a captcha shall be displayed with the form. Default value: `true`

### Notifications

After a poll has been successfully submitted, it is possible to send an email notification to a give address, in order for the site administrator (or someone else) to know that something happens on the website.

* **`app_aPoll_notifications_do_send`**: defines if a notification shall be sent after a successufll poll submission. Default value: `true`.
* **`app_aPoll_notifications_to`**: defines the email address or the username of the person who shall receive the notification. Default value: `admin`.
* **`app_aPoll_notifications_from`**: defines the email address or the username of the person actually sending the notification. Default value: `admin`.
* **`app_aPoll_notifications_title_partial`**: defines the partial rendering the email title. Default value: `aPollSlot/email_title`.
* **`app_aPoll_notifications_body_partial`**: defines the partial rendering the email body. Default value: `aPollSlot/email_body`.


### Reports

apostrpohePollPlugin allows one to export user's answers in various file formts. By default excel and CSV are available. Other export types may be added using the following configuration parameters. For example to define excel export format, we use these parameters:

![export feature](/images/export.png "Export feature")

`
aPoll:  
   reports:  
      excel:  
        label: Export to excel     
        action: aPollPollAdmin/exportToExcel  
        is_generic: true  
`

where:
* `excel`: is the identifier of the report.
* `label`: is the label, which will be rendered as link to the report.
* `action`: is the action which renders the report.
* `is_generic`: defines if this report can be applied to any poll (true) or if it can only be applied to specific polls.

The `is_generic` field is used to define which reports might be proposed by default to export data. If a report is poll-specific, it must be explicitely defined in the poll configuration (see below) in order to appear as export option.


## Custom Captcha
 
