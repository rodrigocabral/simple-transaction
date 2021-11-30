# Simple Transactions

The main objective of this project is simulate a payment transaction. 

### Dependencies

#### Docker

- [Docker](https://docs.docker.com/install/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/downloads)

#### Server

- [PHP](http://php.net/) 7.4
- [Composer](https://getcomposer.org/)
- [Postgres](https://www.postgresql.org/)
- [Nginx](https://www.nginx.com/)

## Install

- Clone this repository: `git clone git@github.com:rodrigocabral/simple-transaction.git && cd simple-transaction`
- Build containers: `docker-compose up -d --build`
- Enter into container: `docker-compose exec php sh`
- Install dependencies: `docker-compose exec php composer install`
- Run migrations: `docker-compose exec php artisan migrate`
- Run seed: `docker-compose exec php artisan db:seed`

### Database configurations

```dotenv
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=transactions
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

### Queue configuration
```dotenv
QUEUE_CONNECTION=database
```

### Tests

```shell
docker-compose exec php vendor/bin/phpunit
```

### Payload

POST http://localhost/api/transaction
```json
{
    "value" : 100.00,
    "payer" : 4,
    "payee" : 15
}
```
