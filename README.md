mapmytown
=========

A superduper joint venture by TagesWoche, NZZ, Le Temps.


Installation
------------

1. Install PHP 5.4
2. Run `php composer.phar install` to install the application's PHP dependencies
3. Check your PHP configuration: `php app/check.php`
4. Dump all assets to the web folder `php app/console assetic:dump`
5. Symlink the web folder `php app/console assets:install web --symlink`
6. Run development server: `php app/console server:run`
7. Visit http://localhost:8000/app_dev.php/nzz/de/18 in your browser


TODO
----

* URL param to change language
