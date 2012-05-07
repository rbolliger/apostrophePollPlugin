# Chapter 5 - Publishing a poll

This chapter explains how to define a poll in an apostrophe CMS website and how to publish it in one or more pages.

As explained in chapter 4, the polls listed in `app_aPoll_available_polls` are templates of polls available for publishing in an apostrophe CMS website. To actually publish a poll, it must first be defined in the administration area. The poll defined in the administration area is an instance of a poll template defined in `app.yml` and acts as container for the answers submitted by the users.

The advantage of this architecture is that one can define multiple instances of a given poll template, which might be published in distinct pages of a website. Think for example about a company having various departments (marketing, customer service, ...) which needs differet contact forms.


## Definition of the poll in the admin area

To create a new poll, click on the `New` button in `aPollPollAdmin` module.

The poll creation form is divided into two distinct parts:
1. One to define publication parameters
2. One to define the poll content

### Publication parameters

These parameters define how the poll will be published. Some of them have already been described in chapter 3, in the "Submissions" section.

* **Template**: lists the poll templates defined in `app_aPoll_available_polls`.
* **Published from**: defines when the poll publication starts. If left empty, no limit is set.
* **Published to**: defines when the poll publication ends. If left empty, no limit is set.
* **Allow multiple submissions?**: defines whether the user can submit multiple consecutive answers.
* **Submissions delay (hh:mm)**: Time delay (in hours and minutes) between two consecutive submissions, if the previous field is set to "Yes".

### Poll content

When published, the poll form is preceded by a title and, if required, a short description. The title and the description are defined in the poll creation form. If the website is internationalized, the admin module allows to define the title and the description for all the cultures enabled in `app.yml`.

## Previewing a poll

By clicking on "Preview poll" in `aPollPollAdmin` you can see what the poll will look like when published and get some useful debugging informations about the poll definition. 

In the first part, the poll template parameters defined in `app.yml` are shown. This lets you know if the parameters are taken into account as you expected.

In the second part a preview of the poll is shown. Notice that the appearance might be a little different than what is actually displayed on the website pages. This is because some CSS parameters might differ between normal and admin pages.


## Publishing the poll in a page of the CMS

apostrpohePollPlugin provides a new slot type allowing to publish a poll in a content slot. To enable this slot type, you have to define it in `app.yml`:

	# apps/frontend/config/app.yml

	all:
	   a:
	       slot_types:
		  ...
		  - aPoll: Poll
		  
You can also enable it in the default slot types:

	# apps/frontend/config/app.yml

	all:
	   a:
	     standard_area_slots:
		  ...
		  - aPoll


These features are described in [Apostrophe documentation](http://trac.apostrophenow.org/wiki/ManualDevelopersGuide#CreatingCustomSlotTypes "Custom slot types").

When adding a new "Poll" slot, a choice widget will ask you which poll shall be published. After saving the choice, the poll will be displayed, unless one or more publication criteria (start and end date, multiple submissions, ...) are not satisfied. In that case, a debugging message will be displayed (only if you are logged in).


