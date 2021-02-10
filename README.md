## DIRECTORY STRUCTURE

---

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      components/         contains common components
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      modules/            contains modules
      messages/           contains common i18n translations
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources
      widgets/            contains widgets

## REQUIREMENTS

The minimum requirement by this project is PHP 7.2+ and mysql 5.7+

## CONFIGURATION

Create the file `config/local/db.php` with your sensitive data, for example:

```php
<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'listing_task');
define('DB_USER', 'listing_task');
define('DB_PASSWORD', 'listing_task');
```

**NOTES:**

- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.

## RUNNING

Update your vendor packages

    docker-compose run --rm app composer update --prefer-dist

Run the installation triggers (creating cookie validation code)

    docker-compose run --rm app composer install

Start the container

    docker-compose up -d

You can then access the application through the following URL:

    http://127.0.0.1:8000

Create database and user you've specified in `config/local/db.php` (mysql root password your can find in mysql container log).

    docker exec -it listing_task_mysql mysql -uroot -pPASSWORD_FROM_LOG

Then

    CREATE DATABASE listing_task;
    CREATE USER 'listing_task'@'%' IDENTIFIED BY 'listing_task';
    GRANT ALL PRIVILEGES ON listing_task.* TO 'listing_task';
    exit

Import database structure (you can find it in `sql/test_db_structure.sql`)

    docker exec -i listing_task_mysql mysql -ulisting_task -plisting_task listing_task < sql/test_db_structure.sql

Import test data (you can find it in `sql/test_db_data.sql.zip` - extract it before)

    docker exec -i listing_task_mysql mysql -ulisting_task -plisting_task listing_task < sql/test_db_data.sql

Apply migrations

    docker-compose run --rm app yii migrate

**NOTES:**

- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches
