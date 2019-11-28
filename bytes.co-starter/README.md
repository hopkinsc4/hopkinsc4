# Bytes.co Starter WordPress Theme Framework

## About

A WordPress theme built with Bootstrap 4, and based on UnderStrap.

## License
Bytes.co Starter WordPress Theme, Copyright 2019 Bytes.co
Bytes.co Starter is distributed under the terms of the GNU GPL version 2

http://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html


## Basic Features

- Combines Underscore’s PHP/JS files and Bootstrap’s HTML/CSS/JS.
- Comes with Bootstrap (v4) Sass source files and additional .scss files. Nicely sorted and ready to add your own variables and customize the Bootstrap variables.
- Uses a single minified CSS file for all the basic stuff.
- [Font Awesome Pro](http://fortawesome.github.io/Font-Awesome/) integration (v5.11.2)
- Jetpack ready.
- WooCommerce support.
- Translation ready.
- WP CLI Scripts to alter site options and install plugins in bulk.

## Confused by All the CSS and Sass Files?

Some basics about the Sass and CSS files that come with Bytes.co Starter:
- The theme itself uses the `/style.css`file only to identify the theme inside of WordPress. The file is not loaded by the theme and does not include any styles.
- The `/css/theme.css` and its minified little brother `/css/theme.min.css` file(s) provides all styles. It is composed of five different SCSS sets and one variable file at `/sass/theme.scss`.

- Your design goes into: `/sass/theme`.
  - Add your styles to the `/sass/theme/_theme.scss` file
  - And your variables to the `/sass/theme/_theme_variables.scss`
  - Or add other .scss files into it and `@import` it into `/sass/theme/_theme.scss`.

## Developing With npm, Gulp and SASS and [Browser Sync][1]

### Installing Dependencies
- Make sure you have installed Node.js and Browser-Sync (optional) on your computer globally
- Then open your terminal and browse to the location of your Bytes.co Starter copy
- Run: `$ npm install`

### Running
To work with and compile your Sass files on the fly start:

- `$ gulp watch`

Or, to run with Browser-Sync:

- First add a file `/browsersync.json` which the following contents, changing `localhost:8000` to whatever your local development URL is.
```javascript
{
    "proxy": "localhost:8000/",
    "notify": false
}
```
- then run: `$ gulp watch-bs`

## Font Awesome Pro 
We use the Bytes.co Font Awesome Pro license. If for any reason we need to upgrade to a newer version, just make sure our auth key is still valid in `.npmrc`. 

If you are looking to minimize css file size, only import the variations of Font Awesome you need in `sass/assets/font-awesome.scss`.

## RTL styles?
Add a new file to the themes root folder called rtl.css. Add all alignments to this file according to this description:
https://codex.wordpress.org/Right_to_Left_Language_Support

## Page Templates
Bytes.co Starter includes several different page template files: (1) blank template, (2) empty template, and (3) full width template.

### Blank Template

The `blank.php` template is useful when working with various page builders and can be used as a starting blank canvas.

### Empty Template

The `empty.php` template displays a header and a footer only. A good starting point for landing pages.

### Full Width Template

The `fullwidthpage.php` template has full width layout without a sidebar.

## WP CLI Scripts 

### Set WordPress Options

Add the name of the options, with the desired value to `starter-wp-options.json`. Run the cli command `wp starter-setup-options` and follow the onscreen instructions.

### Bulk Install & Activate Plugins

Add the name of the plugin, with a `true` value to `starter-wp-plugins.json`. Run the cli command `wp starter-setup-plugins` and follow the onscreen instructions.

## Footnotes

[1] Visit [http://browsersync.io](http://browsersync.io) for more information on Browser Sync

Licenses & Credits
=
- Font Awesome: http://fontawesome.io/license (Font: SIL OFL 1.1, CSS: MIT License)
- Bootstrap: http://getbootstrap.com | https://github.com/twbs/bootstrap/blob/master/LICENSE (Code licensed under MIT documentation under CC BY 3.0.)
and of course
- jQuery: https://jquery.org | (Code licensed under MIT)
- WP Bootstrap Navwalker by Edward McIntyre: https://github.com/twittem/wp-bootstrap-navwalker | GNU GPL
- Bootstrap Gallery Script based on Roots Sage Gallery: https://github.com/roots/sage/blob/5b9786b8ceecfe717db55666efe5bcf0c9e1801c/lib/gallery.php
