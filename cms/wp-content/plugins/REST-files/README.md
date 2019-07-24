## REST files plugin for Wordpress

Author: @arrested-developer

This plugin is intended for use with Wordpress when used as CMS for Gatsby, and
replaces the /media endpoint on the Wordpress REST API, adding not only images
but also all files that have been uploaded to the media library.

This allows Gatsby to import the files and create GraphQL nodes for them, in the
same way as the `gatsby-source-wordpress` plugin already does with images out of
the box.

WARNING - this removes some fields not used by Gatsby from the /media endpoint's
entries. Not recommended unless you are using Wordpress as a decoupled CMS with
Gatsby!
