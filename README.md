# Youfood

Restaurant management application

## Technologies used server side

* [symfony2](http://symfony.com/)

## Technologies used client side
* [Jquery](http://jquery.com/)
* [bootstrap](http://twitter.github.io/bootstrap/)

## Install

```shell
$ php composer.phar install
```

##set config

In /app/config/ rename parameters.yml.dist to parameters.yml

Create database
```shell
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:update --force
```