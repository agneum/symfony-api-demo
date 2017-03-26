API demo
========

A Symfony project created on June 30, 2016, 8:54 am.

Requirements
------------

  * PHP 5.5.9 or higher;
  * PDO-SQLite PHP extension enabled;
  * JSON extension needs to be enabled
  * ctype extension needs to be enabled
  * Your php.ini needs to have the date.timezone setting
  
  **Hint**: use app/check.php to make sure all requirements have been setup properly
```bash
$ php app/check.php
```


Installation 
------------

Before the first launching of the application you should execute next steps:

* Install composer vendors: composer install
* Create a database: ```php app/console doctrine:database:create```
* Create the database structure: ```php app/console doctrine:schema:create```
* [Optional] Load fixtures: ```php app/console doctrine:fixtures:load```

Usage
-----

Run the built-in web server:

```bash
$ php bin/console server:run
```

This command will start a web server for the Symfony application. Now you can
access the application in your browser at <http://localhost:8000>. You can
stop the built-in web server by pressing `Ctrl + C` while you're in the
terminal.