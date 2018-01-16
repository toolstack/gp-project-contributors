# GP Project Contributors

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

