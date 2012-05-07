# Chapter 1: Installation

## Requirements

To work properly, the pluzgin requires the following plugins to be installed:

* apostrophePlugin
* sfFormExtraPlugin

sfFormExtraPlugin is required only if you plan to display a captcha to secure forms submissions. In aprcitluar, sfFormExtraPlugin provides a wrapper to display [recaptcha](http://www.google.com/recaptcha "reCaptcha"). You can also provide your own captcha widget, as described in chapter 7.

apostrpohePollPlugin allows to export answers submitted by users as excel ans CSV files. To enable this feature, you have to install [PHPExcel](http://phpexcel.codeplex.com/). A symfony [plugin](http://trac.symfony-project.org/browser/plugins/sfPhpExcelPlugin/ "sfPhpExcelPlugin") exists, but PHPExcel code might be outdated. To get the latest version, it might be useful to download it as a vendor package (using svn externals) and then load it using an autoload.yml configuration file (see [symfony documentation](http://www.symfony-project.org/reference/1_4/en/14-Other-Configuration-Files#chapter_14_autoload_yml "autoload.yml")).

## Installation

### Using symfony plugin:install

Use this to install apostrophePollPlugin:

	symfony plugin:install apostrophePollPlugin

### Using git clone

Use this to install as a plugin in a symfony app:

	cd plugins
	git clone git://github.com/rbolliger/apostrophePollPlugin.git

### Using git submodules

Use this if you prefer to use git submodules for plugins:

	git submodule add git://github.com/rbolliger/apostrophePollPlugin.git plugins/apostrophePollPlugin   
	git submodule init   
	git submodule update


## Enable the plugin

It the plugin is installed from git or manually, it must be enabled in your project configuration class:
	
	# /config/ProjectConfiguration.class.php   
	class ProjectConfiguration extends sfProjectConfiguration   
	{   
	  public function setup()   
	  {    
	    $this->enablePlugins('apostrophePollPlugin');   
	  }   
	}

## Enable modules

	# /apps/frontend/config/settings.yml   
	.settings   
	  enabled_modules: [..., aPollSlot, aPollPollAdmin, aPollAnswerAdmin](default,)
  
## Adding a button in the top area

apostrophePollPlugin provides a new button pointing to the `aPollPollAdmin` admin module. 

If you installed Apostrophe from the sandbox or if you cannot see the button in the admin bar, you have to enable it in `app.yml`:

	all:
	    a:
		global_button_order:
		    ...
		    - polls
		    ...
            
To learn more about global buttons, have a look at the [Apostrophe documentation](http://trac.apostrophenow.org/wiki/ManualDevelopersGuide#ManagingGlobalAdminButtonstotheApostropheAdminMenu "Adding global buttons").
