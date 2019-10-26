
# symfony4-vue
Symfony 4 skeleton with Vue, Vuex, Vue-router and Webpack (and more!)

## What's included
-Symfony 4.1.0 skeleton

-Docker-compose development environment

-Redis cache

-Twig, Annotations, Webserver and Maker bundles

-Encore webpack with VueLoader and SassLoader configured

-Vue, Vuex and Vue-Router

-Axios is prototyped as $http variable

## Using this boilerplate

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
It will start a server accessible at http://localhost:8080

or

```sh
$ docker-compose up
```

Server will be accessible at http://localhost:8888 and Redis caché will
be available


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


#### UPDATES

April 2019 - Although encore server worked well with spread operator
(...) while development, if you tried to build a production compilation
it did not work. I have updated @symfony/webpack-encore package in order
to get this working without the use of babel plugins. I also updated the
assets folder skeleton to have a page oriented structure.

October 2019 - Added docker-compose file and resources to build images
able to work in this environment. Added a redis cache POF. This
component should be mandatory in all project developed in this century,
because never was easier implementing such enhancement.
