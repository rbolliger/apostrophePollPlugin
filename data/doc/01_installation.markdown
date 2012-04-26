# Chapter 1: Installation #

## Requirements

To work properly, the pluzgin requires the following plugins to be installed:
* apostrpohePlugin
* sfFormExtraPlugin

sfFormExtraPlugin is required only if you plan to display a captcha to secure forms submissions. In aprcitluar, sfFormExtraPlugin provides a wrapper to display [recaptcha](http://www.google.com/recaptcha "reCaptcha"). You can also provide your own captcha widget, as described in chapter 3.

apostrpohePollPlugin allows to export answers submitted by users as excel ans CSV files. To enable this feature, you have to install [PHPExcel](http://phpexcel.codeplex.com/). A symfony plugin exists, but PHPExcel code is outdates. For a manual installation, see the appendix.

## Installation

### Using symfony plugin:install

Use this to install apostrophePollPlugin:

 `symfony plugin:install apostrophePollPlugin`

### Using git clone

Use this to install as a plugin in a symfony app:

`cd plugins && git clone git://github.com/rbolliger/apostrophePollPlugin.git`

### Using git submodules

Use this if you prefer to use git submodules for plugins:

``git submodule add git://github.com/rbolliger/apostrophePollPlugin.git plugins/apostrophePollPlugin   
 git submodule init   
 git submodule update``


## Enable the plugin

It the plugin is installed from git or manually, it must be enabled in your project configuration class:

``# /config/ProjectConfiguration.class.php   
class ProjectConfiguration extends sfProjectConfiguration   
{   
  public function setup()   
  {    
    $this->enablePlugins('apostrophePollPlugin');   
  }   
}``

## Enable modules

`# /apps/frontend/config/settings.yml   
.settings   
  enabled_modules: [..., aPollSlot, aPollPollAdmin, aPollAnswerAdmin](default,)`
  

