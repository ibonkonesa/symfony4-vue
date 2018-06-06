
# symfony4-vue
Symfony 4 skeleton with Vue, Vuex, Vue-router and Webpack (and more!)

## What's included
-Symfony 4.1.0 skeleton

-Twig, Annotations, Webserver and Maker bundles

-Encore webpack with VueLoader and SassLoader configured

-Vue, Vuex and Vue-Router

-Axios is prototyped as $http variable

## Installing

Clone this repository

```sh
$ git clone https://github.com/ibonkonesa/symfony4-vue.git 
```

Install composer and node dependencies

```sh
$ composer install
$ yarn install #recommended
or
$ npm install
```

Compile js and css files

```sh
$ ./node_modules/.bin/encore dev 
```

Execute built in Symfony web server

```sh
$ php bin/console server:run
```
It will start a server accesible at http://localhost:8080

## Vue development

Vue files are located at /assets/js folder. Just modify these files as a regular Vue project.

I suggest you using hot-reload encore server. When a file is updated webpack will be launched automatically. Start it with this command

```sh
$ ./node_modules/.bin/encore dev --watch
```

Files app.js and app.css will be compiled at /public/build folder.

Default controller contains just one root route that renders this necessary files.

SassLoader is activated, so all changes on /assets/js/app.scss will be compiled too.

Axios are prototyped as $http. This service will be available at the whole Vue app.

Vuex and Vue-router are included too. Be free to add as routes and stores as you want.
