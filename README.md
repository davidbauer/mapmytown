mapmytown
=========

A superduper joint venture by TagesWoche, NZZ and Le Temps.


Installation
------------

1. Install PHP 5.4
2. Run `php composer.phar install` to install the application's PHP dependencies
3. Check your PHP configuration: `php app/check.php`
4. Copy `app/config/parameters.yml.dist` to `app/config/parameters.yml`
5. Dump all assets to the web folder `php app/console assetic:dump`
6. Symlink the web folder `php app/console assets:install web --symlink`
7. Run development server: `php app/console server:run`
8. Visit [`/app_dev.php/nzz/de/show`](http://localhost:8000/app_dev.php/nzz/de) in your browser


### Setup DB
1. Install MySQL
1. `php app/console propel:database:create`
1. `php app/console propel:migration:generate-diff`
1. `php app/console propel:migration:migrate`
1. Visit [`/nzz/de/show`](http://localhost:8000/nzz/de) in your browser
