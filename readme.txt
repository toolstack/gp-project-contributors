=== GP Project Contributors ===
Contributors: GregRoss
Donate link: http://toolstack.com/donate
Plugin URI: http://glot-o-matic.com/gp-project-contributors
Author URI: http://toolstack.com
Tags: translation, glotpress
Requires at least: 4.4
Tested up to: 6.4
Stable tag: 1.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin for GlotPress as a WordPress plugin that creates a formated list of contributors to a GlotPress project as a shortcode.

== Description ==

A plugin for [GlotPress as a WordPress plugin](https://github.com/GlotPress/GlotPress-WP) that creates a formated list of contributors to a GlotPress project as a shortcode.

There are two shortcodes available:
* gp-project-contributors - creates a table of contributors per locale.
* gp-project-contributors-translators - creates a table of contributors and string counts per locale.

Each short code can take one of three options:
* name - the name of the project to generate stats for.
* slug - the slug of the project to generate stats for.
* id = the id of the project to generate stats for.

At least one of these must be provided.

For example, if you have a project with a slug of 'glotpress', then the following short code would be used:

	[gp-project-contributors slug=glotpress]

== Installation ==

Install from the WordPress plugin directory.

== Frequently Asked Questions ==

= TBD =

TBD

== Changelog ==
## 1.1
* Release date: March 31, 2024
* Added gp-project-contributors-translators shortcode, thanks [Chris Gårdenberg](https://github.com/itssimple)

## 1.0
* Release date: March 18, 2016
* Documentation updates and official release.

## 0.5
* Release date: December 31, 2015
* Initial release.
