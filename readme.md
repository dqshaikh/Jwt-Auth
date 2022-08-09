# Symfony 5 - Quick Start AUTH JWT

- This bundle provides JWT (Json Web Token) authentication for your Symfony API.


## Commands:
Run below composer command:
- composer require symfony/maker-bundle --dev

Database configuration in .env file in base directory
Change database credential in below parameter:
- DATABASE_URL="mysql://user:password@1@127.0.0.1:3306/databasename?serverVersion=8&charset=utf8mb4"

Generate DataBases And Tables
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate

Start 
- symfony server:start
if not configured symfony on your system use:
- php -S localhost:8000 -t public


## Using

#### SignUp
POST http://127.0.0.1:8000/api/register
- {"username": "admin@gmail.com", "password": "password","name":"name"}
Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character

#### Login - get access token
POST http://127.0.0.1:8000/api/login
- {"username": "admin@gmail.com", "password": "123456"}

#### Get Posts
GET http://127.0.0.1:8000/api/post
- Set Header - Authorization: 'access token'

Example
Authorization: Bearer <access-token>

