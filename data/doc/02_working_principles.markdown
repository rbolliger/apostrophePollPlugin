# Chapter 2: How apostrophePollPlugin works #

## Motivation ##

In a CMS, one can publish different types of forms: polls, contact forms, newsletter subscriptions, .... All these forms have many points in common, like the way data submission and validation is managed, how data is stored and how user-submitted data are then analyzed and managed.

So, why not create a plugin that manages all these common steps? apostrophePollPlugin offers a structured workflow allowing one to publish a form, treat data submission and validation and to manage user-submitted data. The structure is general enough to be applied to a lot of different forms, but is also flexible enough to allow a large degree of customization to adapt to specific points related to each from.

For convenience, we will call "poll" the set of files (a form and some templates) that are actaully published on the website. The "form" is simply the class thet is rendered in a poll.

## Plugin structure ##

The plugin has three modules:
*    aPollSlot, which extends aSlot and provides a new content slot type. This module allows one to publish a poll in various pages of the website.
*    aPollPollAdmin, which allows to define and manage polls. Here an administrator can define some parameters related to the poll publication.
*    aPollAnswerAdmin allows to see and manage data submitted by users.

## What about forms creation? ##

The plugin itself doesn't provide tools to create forms directly online. Some powerful tools already exist for this purpose (see [Wufoo](http://wufoo.com/ "Wufoo") for example, which can be already integrated into Apostrpohe websites). 

In apostrophePollPlugin, we take advantage of symfony's form framework. A form must be created manually, by defining its widgets and validators. Then it can be declared as available for publishing using a special configuration syntax, which will be described in chapter 3. The configuration syntax allows to fully customize the form handling and rendering.

## apostrophePollPlugin vs manual forms definition ##

apostrophePollPlugin provides a structured workflow which helps to manage forms submission, validation and data management. Thanks to the configuration syntax, the form can be rendered and handled in a fully customized way. 

So, the plugin takes care of the tedious work of programming data management and storage wich is required each time someone wants to put a poll online. This is a percious work especially for a CMS, since a publisher or an author doesn't want to take care about the programming of the content management. The plugin still requires the programming of the form itself and, if needed, of some templates. But this is not a so difficult task.

## How data is stored ##

apostrophePollPlugin takes inspiration from [sfDoctrinePollPlugin](http://www.symfony-project.org/plugins/sfDoctrinePollPlugin). Three tables are defined to store data:
*   aPollPoll: this table contains data related to the publication of a given poll.
*   aPollAnswer: this table contains the identifier of a set of user-submitted data. Each time a user submits a poll, a new aPollAnswer is created.
*   aPollAnswerField: this table contains the real user-submitted data. The value set in each widget of a form is saved into a aPollAnswerField. Each item of this table is the related to a aPollAnswer, in order to allow the retrieval of the entire set of data submitted by the user.

This structure is extremely flexible, because it doesn't require to create a new table for each form. Indeed, the association between a form widget and a aPollAnswerField object allows us to define forms with an unlimited number of fields.
