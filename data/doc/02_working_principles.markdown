# Chapter 2: How apostrophePollPlugin works #

## Motivation ##

In a CMS, one can publish different types of forms: polls, contact forms, newsletter subscriptions, .... All these forms have many points in common, like the way data submission and validation is managed, how data is stored and how user-submitted data are then analyzed.

So, why not create a plugin that manages all these common steps? apostrophePollPlugin offers a structured workflow allowing one to publish a form, treat data submission and validation and to manage user-submitted data. The structure is general enough to be applied to a lot of different forms, but is also flexible enough to allow a large degree of customization to adapt to specific points related to each from.

## Plugin structure ##

The plugin has three modules:
* aPollSlot, which extends aSlot and provides a new content slot type. This module allows one to publish a form in various pages of the website.
* aPollPollAdmin, which allows to define and manage forms. Here an administrator can define some parameters related to the form publication.
* aPollAnswerAdmin allows to see and manage data submitted by users.

## What about forms creation? ##

The plugin itself doesn't provide tools to create forms directly online. Some powerful tools already exist for this purpose (see [wufoo](http://wufoo.com/ "Wufoo") for example, which can be already integrated into Apostrpohe websites). 

In apostrophePollPlugin, we take advantage of symfony's form framework. A form must be created manually, by defining its widgets and validators. Then it can be declared as available for publishing using a special configuration syntax, which will be described in chapter 3. The configuration syntax allows to fully customize the form handling and rendering.

## apostrophePollPlugin vs manual forms definition ##

apostrophePollPlugin provides a structured workflow which helps to manage forms submission, validation and data management. Thanks to the configuration syntax, the form can be rendered and handled in a fully customized way. 

So, the plugin takes care of the tedious work of programming data management and storage wich is required each time someone wants to put a form online. This is a percious work especially for a CMS, where a publisher or an author doesn't want to take care about the programming of the content management. The plugin still requires the programming of the form itself and, if needed, of some templates. But this is not a so difficult task.

## How data is stored ##

apostrophePollPlugin taks inspiration from [sfDoctrinePollPlugin](http://www.symfony-project.org/plugins/sfDoctrinePollPlugin) 
