# CakePHP Application Skeleton

[![Build Status](https://img.shields.io/travis/cakephp/app/master.svg?style=flat-square)](https://travis-ci.org/cakephp/app)
[![License](https://img.shields.io/packagist/l/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)

A skeleton for creating applications with [CakePHP](https://cakephp.org) 3.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephp/app
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist cakephp/app myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Update

Since this skeleton is a starting point for your application and various files
would have been modified as per your needs, there isn't a way to provide
automated upgrades, so you have to do any updates manually.

## Configuration
1. Read the document: https://docs.google.com/document/d/1chAZUspautQ6bUgz0c9pG14RWlT2l22Vj402NIklynM/edit and follow the installation instruction.
2. Install timescaledb from the resource https://docs.timescale.com/v1.1/getting-started/installation/ubuntu/installation-apt-ubuntu
3. Create database and execute the sql query which is in config/schema/spayc.sql to create table and schema.
3. Read and configure the environment variable `config/.env`.
4. Database Schema link: https://drive.google.com/file/d/1RArdSxajbYS0bxR878IvIxWuicNnER6j/view
5. Api document link: https://spayc.warp-app.com/apidoc/


## Layout

The app skeleton uses a subset of [Foundation](http://foundation.zurb.com/) (v5) CSS
framework by default. You can, however, replace it with any other library or
custom styles.
