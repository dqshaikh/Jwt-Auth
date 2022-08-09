# Author
- @Aamir Shaikh
- Submission Date: 9th August 2022

# Neotech Challenge
- We are given with a challenge to create a Symfony Backend.
- Generate 100k records using the faker library.
- Implement Login/Singup APIs
- Implement Posts Functionality

# Pre-Requisite
- PHP: 7.4
- MySQL: 5.0 or higher
- Symfony: 5.x

# My Solution
- Integrated JWT with Symfony
- Generated 100k records with a faker library using composer
- Implemented Caching

# Setup Steps

Install and build dependencies through composer
- `composer require symfony/maker-bundle --dev`

Update env file to update the Database Configuration
- `DATABASE_URL="[mysql]://[user]:[password]@[127.0.0.1]:[3306]/[databasename]?serverVersion=[8]&charset=[utf8mb4]"`

Run Migration to create datasets
- `php bin/console doctrine:database:create`
- `php bin/console doctrine:migrations:migrate`

Start the Server
- `symfony server:start`

OR

In case, symfony is not configured on the system:
- `php -S localhost:8000 -t public`


# Usage
- [Postman Collection](/Neotech-Challenge.postman_collection.json)

## Sign Up
```
POST http://127.0.0.1:8000/api/register

Body
{
    "username": "admin@gmail.com",
    "password": "password",
    "name":"name"
}

Validation Check: Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character
```

## Login
```
Description: Create access token

POST http://127.0.0.1:8000/api/login

Body
{
    "username": "admin@gmail.com",
    "password": "123456"
}
```

## Get Posts
```
GET http://127.0.0.1:8000/api/post

Set Header
- `Authorization: "Bearer <Access Token>"`
```


# License
MIT

