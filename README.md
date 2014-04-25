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

To change WordPress versions use:

```
cd public/wp
git checkout [version #]
```

To update WordPress versions:

```
cd public/wp
git fetch --all
git fetch --tags
git checkout [version #]
```

OR

If you have already updated and are pulling an update from an upstream branch:
```
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
bin/db_sync.sh
```
To clone a production (or any upstream) uploads folder you can use uploads_sync:

```
bin/uploads_sync go
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

### grunt
wp-boilerplate uses Grunt to compress Javascript files and run Compass. Run
`npm install` from the root directory to install node dependencies, then run
`grunt` to watch for changes in `js/src` and `style/sass` in the theme
directory.

## features
### multi-environment handling in wp-config
Allows you to define settings for multiple environments. Each environment
inherits settings from the `$default` settings array.

Create an empty file named `env_local` or `env_stage` in the web root folder
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

### included plugins
**[WordPress SEO (Yoast)](http://wordpress.org/extend/plugins/wordpress-seo/):** Full featured SEO plugin for expert control over WordPress  
**[Advanced Custom Fields](http://www.advancedcustomfields.com/):** Great plugin that enables advanced CMS functionality in WordPress  

### included javascript
Includes some nice stuff like [Modernizr](http://modernizr.com/),
[Respond](https://github.com/scottjehl/Respond),
[Bootstrap](http://getbootstrap.com), [jQuery
Placeholder](https://github.com/mathiasbynens/jquery-placeholder), [jQuery
imagesLoaded](https://github.com/desandro/imagesloaded), and [jQuery
Validation](http://bassistance.de/jquery-plugins/jquery-plugin-validation/).

All Javascript (with exception of Modernizr, Respond, and jQuery (CDN) is
compiled by Grunt into a 'main.js' file included in the footer.

### included CSS
[Bootstrap](http://getbootstrap.com) is included as an scss file, to use
uncomment it in the screen.scss file.

```
/* Bootstrap v3.1.1 */
//@import "bootstrap";
```

### included fonts
[Font Awesome](http://fontawesome.io/) is also included from the Bootstrap CDN,
to use uncomment it in the assets.php file.

```
// Font Awesome stylesheet
// wp_enqueue_style('font-awesome', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', false, null, false);
```

### default compass configuration
Includes default configuration for SASS/Compass, which comes highly
recommended.

## dependencies
[node](http://nodejs.org)  
[Grunt](http://gruntjs.com): `npm install -g grunt-cli`  
[SASS](http://sass-lang.com/): `gem install sass`  
[Compass](http://compass-style.org/): `gem install compass`  
[Compass Normalize](https://github.com/ksmandersen/compass-normalize): `gem install compass-normalize`  
[Compass rgbapng](https://github.com/aaronrussell/compass-rgbapng): `gem install compass-rgbapng`  

## license

MIT
