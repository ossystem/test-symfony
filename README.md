# test-symfony

Let's assume that you have composer installed and PHP env configured.
In order to run this project do the following:
- clone the project and cd to it
- run `composer install`
- edit `.env` file to set `DATABASE_URL`
- `php bin/console doctrine:database:create`
- `php bin/console doctrine:migration:migrate`
- that's it!
