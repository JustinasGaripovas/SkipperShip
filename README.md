# Skipper Ship

One Paragraph of project description goes here

### General conduct

* No commiting directly to master.
* For changing database schema we use migrations.
* All merges should be approved by other team member.

### Prerequisites

Good practice before installing:
```
sudo apt update
```

This project requires composer:
* [Composer](https://getcomposer.org/download/) - PHP Dependency Management


### Installing

In project directory(./SkipperShip):

```
composer upgrade
```
## Env setup

Enviroument file example:

/.env
```
APP_ENV=dev
APP_SECRET=332b8b4ac882914272da09e1e9c3a23b

DATABASE_URL=mysql://DATABASE_USER_USERNAME:DATABASE_USER_PASSWORD@127.0.0.1:3306/skipper_ship
```

## Database setup
```
bin/console doctrine:database:create
```
```
bin/console doctrine:migration:migrate
```
OR (not recommended)
```
bin/console doctrine:schema:update --force
```

## Fixtures

Optional step if you need auto generated data
```
bin/console doctrine:fixture:load
```



## Built With

* [Symfony 5](https://symfony.com/) - The web framework used
* [composer](https://getcomposer.org/download/) - Dependency Management

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Authors

* **Justinas Garipovas** - *Initial work* - [JustinasGaripovas](https://github.com/JustinasGaripovas)

