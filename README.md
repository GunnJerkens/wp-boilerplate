## wp-boilerplate

GunnJerkens Wordpress boilerplate theme + plugins

To initialize a new project, clone and then execute the init.sh script:

```
./init.sh
```

This will remove the .git folder, initialize it as a new repo, loop through .gitmodules to initialize the submodules, and install the WordPress core.

*Gotcha: the submodules will be checked out at the tip of their master branch instead of the same commit as the boilerplate repo*

After initializing a new project, enter your environment variables in wp-config.php and db_sync.sh.  You can then run db_sync.sh to sync down from the production database:

```
./db_sync.sh
```

To clone and edit the boilerplate repo normally, run `git submodule update --init` to retrieve submodules.

### Grunt

wp-boilerplate uses Grunt to compress Javascript files and run Compass. Run `npm install` from the root directory to install node dependencies, then run `grunt` to watch for changes in `js/src` and `style/sass` in the theme directory.

## Features
### Multi-environment handling in wp-config
Allows you to define settings for multiple environments. Each environment inherits settings from the `$default` settings array.

Create an empty file named `env_local` or `env_stage` in the WordPress root folder for it to pick up settings specific to those environments.

Environment hostnames are specified so that you don't have to do a search and replace in the database everytime you sync a database dump to a different environment.

### Easy Password Protection
Environments can have `'password_protect' => true`. A function in the theme's functions.php will pick up on that and require a WP login to view the site if set to true.

### Embedded media uses domain-agnostic HTTP paths
A call is made for `update_option('upload_url_path', '/wp-content/uploads');` which forces media to be embedded with a src like `/wp-content/uploads/media.jpg` instead of `http://domain.com/wp-content/uploads/media.jpg`. Coupled with defining the environment hostnames in wp-config.php, this enables us to not have to worry about doing a search & replace in the database when changing hostnames.

### Included Plugins
**[WPThumb](http://hmn.md/blog/2011/10/19/introducing-wp-thumb/):** Seamlessly integrates with native WordPress image functions to crop, resize, and cache uploaded media on-demand.
**[Uploads by Proxy](http://wordpress.org/extend/plugins/uploads-by-proxy/):** Automatically retrieves uploaded media from a remote server (production or staging) if it doesn't exist locally
**[Advanced Custom Fields](http://www.advancedcustomfields.com/):** Great plugin that enables advanced CMS functionality in WordPress
**[Enable Media Replace](http://wordpress.org/extend/plugins/enable-media-replace/):** Enables replacement of uploaded media for updates
**GJ Maps:** Plugin for storing Point of Interest data to be used with the Google Maps API. Not recommended for production use.

### Included Javascript
Includes some nice stuff like [Modernizr](http://modernizr.com/), [Respond](https://github.com/scottjehl/Respond), [jQuery Placeholder](https://github.com/mathiasbynens/jquery-placeholder), [jQuery imagesLoaded](https://github.com/desandro/imagesloaded), and [jQuery Validation](http://bassistance.de/jquery-plugins/jquery-plugin-validation/).

### Default Compass Configuration
Includes default configuration for SASS/Compass, which comes highly recommended.

## Dependencies
[node](http://nodejs.org)
[Grunt](http://gruntjs.com): `npm install -g grunt-cli`
[SASS](http://sass-lang.com/): `gem install sass`
[Compass](http://compass-style.org/): `gem install compass`
[Compass Normalize](https://github.com/ksmandersen/compass-normalize): `gem install compass-normalize`
