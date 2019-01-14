# wp-boilerplate

## usage

GunnJerkens Wordpress boilerplate theme + plugins

To initialize a new project, clone and then execute the interactive init.sh
script.

```
./init.sh
```

This will remove the .git folder, initialize it as a new repo, loop through
.gitmodules to initialize the submodules, and install the WordPress core as a
submodule. Based on user responses it can also enter your environment variables
into wp-config and will place an env_* file in the root. Prior to completion it
will insert a fresh set of salts from the WordPress API and checkout WordPress
to the latest stable version.

***After the init script completes make sure to login to the wp-admin panel and
activate the GJ-Boilerplate theme and installed plugins. Also set your permalinks.***

To change WordPress versions use:

```
git -C public/wp checkout [version #]
```

To update WordPress versions:

```
git -C public/wp fetch --all --tags
git -C public/wp checkout [version #]
```

OR

If you have already updated and are pulling an update from an upstream branch:
```
git -C public/wp fetch --tags
git submodule update
```

After initializing a new project, you can manually adjust any of the wp-config
variables and also enter in your staging and production credentials if
available.

The wp-config defaults for a local environment having a MySQL username of
'root' with a blank password. If you need different local configuration than
your collaborators, put your special configurations in a JSON object inside
`env_local`, matching the structure of the `$env_default` variable in
`wp-config.php`. Here's an example:

```
{
  "db_host":"127.0.0.1",
  "db_user":"iownthistown",
  "db_pass":"fersher"
}
```

After configuring the /bin/config.sh (sample included) with require credentials
you can clone assets.

To clone a production (or any upstream) database locally you can use db_sync:

```
bin/db_fetch.sh
```
To clone a production (or any upstream) uploads folder you can use uploads_sync:

```
bin/uploads_sync.sh go
```
*Leave off `go` to do do a dry run, to only list files that will be copied.*

To clone and edit the boilerplate repo normally, run `git submodule update
--init` to retrieve submodules.

### file structure
```
bin/
public/
  content/
  shared/
  wp/
```

The wp directory is a submodule and should not be modified in any way, the
content directory houses themes and plugins. The Shared directory is where all
uploaded files (via the WordPress backend) are stored.

### webpack
wp-boilerplate uses Webpack to compress Javascript files and compile Sass to CSS. Run
`npm install` from the root directory to install node dependencies, then run
`npm run watch` to watch for changes in `js` files and `scss` files.

To compile a dev environment (concatenated js, watch):

`npm run start`

To compile a production build (Uglify JS):  

`npm run build`

## features
### multi-environment handling in wp-config
Allows you to define settings for multiple environments. Each environment
inherits settings from the `$default` settings array.

Create an empty file named `env_local` or `env_staging` in the web root folder
(/public/) for it to pick up settings specific to those environments.

Environment hostnames are specified so that you don't have to do a search and
replace in the database everytime you sync a database dump to a different
environment.

### easy password protection
Environments can have `'password_protect' => true`. A function in the theme's
functions.php will pick up on that and require a WP login to view the site if
set to true.

### embedded media uses domain-agnostic HTTP paths
A call is made for `update_option('upload_url_path', '/content/uploads');`
which forces media to be embedded with a src like `/content/uploads/media.jpg`
instead of `http://domain.com/wp-content/uploads/media.jpg`. Coupled with
defining the environment hostnames in wp-config.php, this enables us to not
have to worry about doing a search & replace in the database when changing
hostnames.

### bin scripts
In the root there are /bin/ scripts that allow easy syncing of databases and
images from an upstream environment.

### disabled WordPress file editor
The WordPress dahsboard file editor is disabled by default, since this project is intended to be version controlled.

### included plugins
**[WordPress SEO (Yoast)](http://wordpress.org/extend/plugins/wordpress-seo/):** Full featured SEO plugin for expert control over WordPress  
**[Advanced Custom Fields](http://www.advancedcustomfields.com/):** Great plugin that enables advanced CMS functionality in WordPress  

## Javascript
Javascript should be modular and loaded as needed per page.

The entry javascript file can be found in 'public/content/themes/gj-boilerplate/js/src/scripts.js'.  Webpack will only compile files that are imports (or dependencies) in this file.

IMPORTANT: Only add JS to 'scripts.js' that is needed for all pages including for global functions.

For page specific JS, enqueue the script based on template name in '/inc/assets.php'. This makes page loads more efficient so only JS needed for each page is loaded.

### included javascript
[Slick (slider)](http://kenwheeler.github.io/slick/)
modals.js (custom) - reusable modal component that is responsive, accessible, and allows for any type of content.
animations.js - standard set of GJ animations. Add/remove as needed.

## CSS
SASS/CSS to be structured in a mobile first approach. Default styles are for all screen sizes. Add a media query via the SASS mixin for min-width styles.

Available mixins:
* Media query: min-width for mobile first, takes in a number value:
```
@include respond-to($breakpoint) {...styles}
```
* Fluid type: take in min-font-size, max-font-size, lower-width, upper-width:
```
fluid-type($min-font-size, $max-font-size, $lower-range, $upper-range);
```
* Placeholder: sets styles for all browser prefixes for input placeholders:
```
@include placeholder() { ...styles }
```

### included CSS
[Slick (slider)](http://kenwheeler.github.io/slick/) - base styles for module.

### included Google Tag Manager integration
Option to add your `GTM ID` in GJ Options. A GTM custom event named `formSubmitted` also fires when the form is submitted successfully so you can track conversions on the ajax form submit.

## dependencies
[node](http://nodejs.org)  
```
npm install
```

## license

MIT
