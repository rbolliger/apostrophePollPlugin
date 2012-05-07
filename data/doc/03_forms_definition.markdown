# Chapter 3: Definition of the form class

apostrophePollPlugin publishes forms built with the symfony form framework. The framework is extremely powerful and flexible and provides a great bunch of features, such as widgets and validators.

To learn how to define a form class with the symfony form framework, have a look at the [official documentation](http://www.symfony-project.org/forms/1_4/en/ "Symfony 1.4 form framework documentation"). 


## How to create a form for a poll

In order to be integrated as a content slot in Apostrophe CMS websites, a form must provide some additional informations with respect to a normal form. This is because apostrophe need to know the identifier of the slot and of the area containing it and a few additional stuff in order to enable administration features.

To ease this work, apostrophePollPlugin provides a base form, which defines some widgets and validators, which will be rendered as hidden fields.

When creating a new poll, the form must extend the `aPollBaseForm`:

	class exampleForm extends aPollBaseForm {
		
	    public function configure()
  	    {

	   	...
	   
	    }
	}


## Saving the form values in the DB

As explained in chapter 2, form values are saved in `aPollAnswerField` table. But, depending on the type of form, not all fields shall be saved. Take for example a registration form, where it is usual to display a password field twice, in order to ensure that it is typed correctly.

By default, apostrophePollPlugin doesn't save any field. To tell the plugin which fields shall be saved, use the `setFieldsToSave()` function provided by `aPollBaseForm`:

	public function configure()
	  {
	      
	   ...
	    
	    $this->setFieldsToSave(array('author_email', 'author_name', 'object', 'message'));
	    

	  }
	  
The plugin will then save in the DB those fields which are not empty.

## Translation of the form fields, help and errors messages

The symfony form framework is internationalizable by default. Look at the [form framerosk documentation](http://www.symfony-project.org/forms/1_4/en/08-Internationalisation-and-Localisation "Form framework - chapter 8") to learn how this works. The [symfony documentation](http://www.symfony-project.org/gentle-introduction/1_4/en/13-I18n-and-L10n "Symfony documentation - chapter 13") is also an excellent source to learn how internationalization works in the symfony framerork (and in Apostrophe CMSes).


By default, translation strings are stored in the `apostrophe` xliff catalogue. To add new translation, it is possible to add new strings to `apps/frontend/i18n/apostrophe.XX.xml`, where `XX` is the culture.

It is also possible to create a new xliff catalogue to store the translation of a given form, by redefining the translation catalogue of the form:

	class aPollContactForm extends aPollBaseForm {

	  public function configure()
	  {
	  
	  ...
	  
	  $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('newCatalogue');
	  
	  }
	}

Then, create the `newCatalogue.XX.xml` in the i18n directory. 
