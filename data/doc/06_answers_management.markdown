# Chapter 6 - Answers management

## Displaying answers 

In the polls administration module, each poll has an "Actions" section containing possible actions that can be run for each poll.

One of these buttons allows to display the list of the answers submitted by the users. Clicking on it takes to the `aPollAnswerAdmin` module. The module allows to show each answer individually.

## Exporting answers and creating reports

A more useful way to analyze user-submitted answers is to export them or to render them in a report. A "Reports" menu is available in the "Actions" section of the polls administration module.

![export menu](images/export.png "Export feature")

By default, apostrophePollPlugin provides export support to CSV (comma-separated values) and to Excel files.

## Adding custom report types

Each poll contains specific data, which may be displayed in different ways. For example, a poll may be statistically analyzed and a contact form may contain the email of the person who requires an information. apostrophePollPlugin is not aware of the content of a poll and cannot provide specific behaviours (like a chart) automatically.

Depending on the type of data collected by the poll, you may want to render them in a particular and specific way. To cite some examples, it may be useful to display an HTML report with interactive statistical charts, a pdf report with beautiful charts and rich texts, and so on.

Tanks to the symfony structure, it is very easy to provide new export types to apostrophePollPlugin. As for polls, an export feature is a set of actions, templates and configuration parameters.

### Configuration

Reports must be declared with the following structure:

	# app/frontend/config/aPoll.yml
	all:
	    settings:
		  reports:
		    ...
		    excel:
		      label: Export to excel
		      action: aPollPollAdmin/exportToExcel
		      is_generic: true
		    ...

Where `excel` is the report identifier, `label` is the name of the report, `action` is the action that will render the report and `is_generic` defines if the report may be applied to any kind of poll. Exporting to excel and CSV may be applied to any poll. A statistical report will probably be very specific to a particular kind of poll.

If `is_generic` is set to `false`, the report will be enabled only for those polls which explicitly require it (see chapter 4).

To learn how excel exporting works, have a look at `plugins/apostrophePollPlugin/modules/aPollPollAdmin/actions/actions.class.php`.

## Cascading configuration

Reports may be defined in different locations. As explained in chapter 4, the cascading configuration is particulary useful to add new report types from externals sources like other plugins or from the project itself. Reports may be declared in the `aPoll.yml` file and will be collected in the `apoll_settings_reports` array by the configuration mechanism.


