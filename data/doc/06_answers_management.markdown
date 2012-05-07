# Chapter 6 - Answers management

## Show answers 

In the polls administration module, each poll has a "Actions" section containing possible actions that you can run for the given poll.

One of these buttons allows to display the list of the answers submitted by the users. Clicking on it takes to the `aPollAnswerAdmin` module. The module allows to show each answer individually.

## Exporting answers and creating reports

A more useful way to analyze user-submitted answers is to export them or to render them in a report. A "Reports" menu is available in the "Actions" section of the polls administration module.

By default, apostrophePollsPlugin provides export support to CSV (comma-separated values) and to Excel files.

## Adding custom report types

Each poll contains specific data, which may be displayed in different ways. A poll may be statistically analyzed, a contact form may contain the email of the person who requires an information. apostrophePollPlugin is not aware of the content of a poll and cannot provide specific behavhiors (like a chart) automatically.

But, depending on the type of data collected by the poll, you may want to render them in a particular and specific way. To cite some examples, it may be useful to display an html report with interactive statistical charts, a pdf report with beautiful charts and rich texts, and so on.

Tanks to the symfony structure, it is extremely easy to provide new export types to apostrophePollPlugin. As for polls, an export feature is a set of actions, templates and configuration parameters.

### Configuration

Reports must be declared with nthe followin structure:

	all:
	    aPoll:
		reports:
		    excel:
		      label: Export to excel
		      action: aPollPollAdmin/exportToExcel
		      is_generic: true

Where `excel` is the report identifier, `label` is the name of the report, `action` is the action that will render the report and `is_generic` defines if the report may be aplied to any kind of poll. Exporting to excel and CSV may be applied to any poll. A statistical report will probably be very specific to a particular kind of poll.

If `is_generic` is set to `false`, the report will be enabled only for those polls which explicitely require it (see chapter 4).

To learn hot excel exporting works, have a look at `plugins/apostrophePollPlugin/modules/aPollPollAdmin/actions/actions.class.php`.
