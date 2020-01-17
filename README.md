# Calacas WP Custom Theme

## Requirements

- PHP, MySQL and a webserver are required.

## Getting Started

### Step 1: Set WP env

Install only the theme and plugins using a WP instance from your preferred WP dev env tool (Local by flywheel, mamp, xampp, docker).

- Once WordPress is installed, open the OS terminal and navigate into the Project path.
- Clone this project repo from the installed WP `ROOT` folder into a temp folder `git clone [url] temp`
- Merge the files from temp to current root folder `rsync -arvzP temp/* .`
- Also merge the hidden dotfiles `rsync -arvzP temp/.[^.]* .`
- Delete the temp `rm -rf temp/`

For Windows Users

- Manually copy all content from `temp/` to `ROOT` using explorer, including hidden files, then delete that `temp/` folder.

### Step 2: Pull/Sync DB from DEV Server

- Under WP Admin Panel go to `plugins` section and `activate` the plugins: `WP Sync DB` and `WP Sync DB Media Files`.
- Pull/Sync latest DB from DEV server: Go to `Tools/Migrate DB` and, on the `Migrate` Tab, choose `Pull` option and enter the DEV Server `connection info (Site URL + Secret key)`.
- Set desire options, ex. you would like to activate the `Media Files` to import images used on DEV Server.
- If your local env don't use `https` make sure to change `find/replace` options including the corresponding HTTP protocol, Ex. https://prod_domain.com => http://devlocal_domain.wp
- Did you forget to check if your local support `https`? You will need to access the `wordpress_db` DB, look into `[wpprefix]_options` table and change the option `siteurl` and `home` to use `http`.
- Save Migration Profile for future DB synchronization
- Press `Migrate DB and Save`.

> Remember: Once DB is synced your credentials are the ones from DEV Server.

### Step 3: Check Theme Resources and Dev requirements

This project is based on [WP RIG Theme Boilerplate](https://github.com/wprig/wprig). WP Rig is built to promote the latest best practices for progressive web content and optimization. Building a theme from WP Rig means adopting this approach and the core principles it is built on:

- Accessibility
- [Lazy-loading of images ](https://developers.google.com/web/fundamentals/performance/lazy-loading-guidance/images-and-video/)
- Mobile-first
- Progressive enhancement
- [Resilient Web Design](https://resilientwebdesign.com/)
- Progressive Web App enabled
- AMP-ready

#### WP Rig Documentation

Documentation for the WP Rig Open Source Project can be found at the dedicated [Docs](https://github.com/wprig/docs/) repo.

#### Requirements

WP Rig requires the following dependencies. Full installation instructions are provided at their respective websites.

- [PHP](http://php.net/) 7.3
- [npm](https://www.npmjs.com/)
- [Composer](https://getcomposer.org/) (installed globally)
- [Update to Gulp 4](#updating-to-gulp-4) (This is important!)

### Step 3: Start Coding

Happy coding!!!.

## Working with WP Rig

1. From your OS terminal or any command line move to `calacas-dev` theme folder, run `cd wp-content/themes/calacas-dev`.
2. From `calacas-dev` theme folder run `npm run rig-init` to install necessary node and Composer dependencies.
   - `npm run rig-init` runs both `npm install` and `composer install` but you can run these seperately.
3. In command line, run `npm run dev` to process source files, build the development theme, and watch files for subsequent changes.
   - `npm run build` can be used to process the source files and build the development theme without watching files afterwards.
4. In WordPress admin, activate the `calacas-dev` development theme.

### Available Processes

#### `dev watch` process

`npm run dev` will run the default development task that processes source files. While this process is running, source files will be watched for changes and the BrowserSync server will run. This process is optimized for speed so you can iterate quickly.

#### `dev build` process

`npm run build` processes source files one-time. It does not watch for changes nor start the BrowserSync server.

#### `translate` process

The translation process generates a `.pot` file for the theme in the `./languages/` directory.

The translation process will run automatically during production builds unless the `export:generatePotFile` configuration value in `./config/config.json` is set to `false`.

The translation process can also be run manaually with `npm run translate`. However, unless `NODE_ENV` is defined as `production` the `.pot` file will be generated against the source files, not the production files.

#### `production bundle` process

`npm run bundle` generates a production ready theme `calacas-theme` as a new theme directory in `wp-content/themes` and, optionally, a `calacas-theme.zip` archive. This builds all source files, optimizes the built files for production, does a string replacement and runs translations. Non-essential files from the `wp-rig` development theme are not copied to the production theme.

To bundle the theme without creating a zip archive, define the `export:compress` setting in `./config/config.json` to `false`:

```javascript
export: {
	compress: false
}
```

### Gulp process

WP Rig uses a [Gulp 4](https://gulpjs.com/) build process to generate and optimize the code for the theme. All development is done in the `wp-rig` development theme. Feel free to edit any `.php` files. Asset files (CSS, JavaScript and images) are processed by gulp. You should only edit the source asset files in the following locations:

- CSS: `assets/css/src`
- JavaScript: `assets/js/src`
- images: `assets/images/src`

#### Updating to Gulp 4

Gulp 4 uses an updated CLI (Command Line Interface). If the computer you are using already has Gulp installed, there is a good chance you have an older version of the CLI and you will encounter errors when trying to run WP Rig.

To update the Gulp CLI to work with Gulp 4, run the following commands in the command line terminal:

```
# Uninstall Gulp globally:
npm uninstall gulp -g

# Install the latest version of the Gulp 4 CLI globally:
npm install gulpjs/gulp-cli -g
```

You may have to run `npm install` again from the WP Rig directory to ensure Gulp 4 is installed and ready to run.
