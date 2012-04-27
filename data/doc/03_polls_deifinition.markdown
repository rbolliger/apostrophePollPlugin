# Chapter 3: polls definition

## Introduction

As explained in chapter 2, a poll is a set of files. In particular, a poll is composed by a form class, plus some templates. apostrophePollPlugin already provides default templates for rendering the form and to confirm a successful submission. Thanks to the configuration parameters, it is possible to customize them to fit the poll's specific needs.

The poll configuration parameters are based on a cascade architecture. When looking for a parameter, the plugin will look at:
1. Poll's parameters
2. General parameters
3. Plugin default parameters

So, one can define general parameters, valid for all polls published on the website and then override them with specific values for each poll. If nothing is defined for a given parameter, apostrophePollPlugin will provide a default value.

General and poll-spicific parameters are defined in app.yml. For a complete exapmple, you can look at the app.yml.template file provided with the plugin.
