## wp-boilerplate

GunnJerkens Wordpress boilerplate theme + plugins

To initialize a new project, clone and then execute the interactive init.sh script.

```
bin/init.sh
```

This will remove the .git folder, initialize it as a new repo, loop through .gitmodules to initialize the submodules, and install the WordPress core as a submodule. Based on user responses it can also enter your environment variables into wp-config and will place an env_* file in the root. Prior to completion it will insert a fresh set of salts from the WordPress API and checkout WordPress to the latest stable version.

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
git checkout master
git pull
git checkout [version #]
```

After initializing a new project, you can manually adjust any of the wp-config variables and also enter in your staging and production credentials if available.

The wp-config defaults for a local environment having a MySQL username of 'root' with a blank password.

To clone a production database locally you can use db_sync.

```
bin/db_sync.sh
```

To clone and edit the boilerplate repo normally, run `git submodule update --init` to retrieve submodules.

### File Structure
--public  
----content  
----shared  
----wp  

The wp directory is a submodule and should not be modified in any way, the content directory houses themes and plugins. The Shared directory is where all uploaded files (via the WordPress backend) are stored.

### Grunt

wp-boilerplate uses Grunt to compress Javascript files and run Compass. Run `npm install` from the root directory to install node dependencies, then run `grunt` to watch for changes in `js/src` and `style/sass` in the theme directory.

## Features
### Multi-environment handling in wp-config
Allows you to define settings for multiple environments. Each environment inherits settings from the `$default` settings array.

Create an empty file named `env_local` or `env_stage` in the web root folder (/public/) for it to pick up settings specific to those environments.

Environment hostnames are specified so that you don't have to do a search and replace in the database everytime you sync a database dump to a different environment.

### Easy Password Protection
Environments can have `'password_protect' => true`. A function in the theme's functions.php will pick up on that and require a WP login to view the site if set to true.

### Embedded media uses domain-agnostic HTTP paths
A call is made for `update_option('upload_url_path', '/wp-content/uploads');` which forces media to be embedded with a src like `/wp-content/uploads/media.jpg` instead of `http://domain.com/wp-content/uploads/media.jpg`. Coupled with defining the environment hostnames in wp-config.php, this enables us to not have to worry about doing a search & replace in the database when changing hostnames.

### Included Plugins
**[WPThumb](http://hmn.md/blog/2011/10/19/introducing-wp-thumb/):** Seamlessly integrates with native WordPress image functions to crop, resize, and cache uploaded media on-demand.  
**[Uploads by Proxy](http://wordpress.org/extend/plugins/uploads-by-proxy/):** Automatically retrieves uploaded media from a remote server (production or staging) if it doesn't exist locally.  
**[Advanced Custom Fields](http://www.advancedcustomfields.com/):** Great plugin that enables advanced CMS functionality in WordPress.  

### Included Javascript
Includes some nice stuff like [Modernizr](http://modernizr.com/), [Respond](https://github.com/scottjehl/Respond), [Bootstrap](http://getbootstrap.com), [jQuery Placeholder](https://github.com/mathiasbynens/jquery-placeholder), [jQuery imagesLoaded](https://github.com/desandro/imagesloaded), and [jQuery Validation](http://bassistance.de/jquery-plugins/jquery-plugin-validation/).

All Javascript (with exception of Modernizr, Respond, and jQuery (CDN) is compiled by Grunt into a 'main.js' file included in the footer.

### Included CSS
[Bootstrap](http://getbootstrap.com) is included as an scss file, to use uncomment it in the screen.scss file.

```
/* Bootstrap v3 */
//@import "bootstrap";
```

### Included Fonts
[Font Awesome](http://fontawesome.io/) is also included from the Bootstrap CDN, to use uncomment it in the assets.php file.

```
// Font Awesome stylesheet
// wp_enqueue_style('font-awesome', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', false, null, false);
```

### Default Compass Configuration
Includes default configuration for SASS/Compass, which comes highly recommended.

## Dependencies
[node](http://nodejs.org)  
[Grunt](http://gruntjs.com): `npm install -g grunt-cli`  
[SASS](http://sass-lang.com/): `gem install sass`  
[Compass](http://compass-style.org/): `gem install compass`  
[Compass Normalize](https://github.com/ksmandersen/compass-normalize): `gem install compass-normalize`  
