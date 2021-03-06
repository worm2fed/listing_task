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

Create the env file `.env` with all main settings according to example file `.env.example`

## RUNNING

Update your vendor packages

    docker-compose run --rm app composer update --prefer-dist

Run the installation triggers (creating cookie validation code)

    docker-compose run --rm app composer install

Start the container

    docker-compose up -d

You can then access the application through the following URL:

    http://127.0.0.1:8000

Unzip `sql/test_db_data.sql.zip` to the same folder (do not change name!)

Apply migrations

    docker-compose run --rm app yii migrate

**NOTES:**

- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches
