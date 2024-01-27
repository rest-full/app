# Rest-Full App

## About Rest-Full App

A skeleton for creating applications with Rest-full 1.x.

The framework source code can be found here: [rest-full/rest-full](https://github.com/rest-full/rest-full).

## Installation

* Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
* Run `php composer.phar create-project rest-full/app [app_name]` or composer installed globally `compser create-project rest-full/app [app_name]`.

Obs: app_name is the folder that will be created by the composer, if you don't have a name you will create the app folder.

## Preparing for development

Even if you know the process, remember it.

You will have to activate composer.json and package.json to have vendor and node_modules.

Gulp needs node_modules installed.

Only then will activate gulp with run develop for your css and javascript to be created automatically with the change you will make in the development.

And you will develop the site or system with php in the src folder, which is already separated in MVC, you can rest assured.

## Preparing for production

Now that you're ready to put it on the server, let's do the following:
* run the package.json run production, that it will do the same thing as the run developer just by minifying the files so they don't weigh on the server
* the folders and files that will be taken for further production are:
     * [x] abstration
     * [ ] assets
     * [x] config
     * [x] log
     * [x] node_modules
     * [x] src
     * [x] vendor
     * [x] webroot
     * [ ] .gitignore
     * [x] .htacces
     * [ ] composer.json
     * [ ] gulpile.js
     * [x] index.php
     * [ ] license
     * [ ] package.json
     * [ ] readme.md
     * [ ] scrutinize.yml


## License

The rest-full framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

