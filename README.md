# Midoriya

Midoriya is a PHP back end implementing EasyAdmin interface in order to CRUD a product model into a PostgreSQL database. It also comes with an API allowing you to register and login using JWT to communicate and interact with [Shigaraki](https://github.com/ValentinFLGT/Shigaraki) the Kotlin back end. Both installation are required to work properly ! 

## Getting started

### Required 

- [Symfony 4.4](https://symfony.com/doc/current/setup.html)
- [Docker Desktop](https://hub.docker.com/)
- [Postman](https://www.postman.com/downloads/)

#### Setting up the Database
- Clone or download the repository
- Move inside the project directory with `cd Documents/Midoriya`
- Run `docker-compose up`

#### Setting up the project
- Open the terminal, move inside the project with `cd Midoriya` then run `composer install`
- You can customize the .env file inside the root to fit with your database's name, postgres port ...
- Create the database with [Doctrine](https://symfony.com/doc/current/doctrine.html) running `php bin/console doctrine:database:create`
- Execute the migration with `php bin/console doctrine:migrations:migrate`
- Run `symfony server:start`

## API / Endpoints / Main commands

You can try the API with the Postman collection `Midoriya.postman_collection.json`. 

---
- **POST** `/register` - Register a user, required to authenticate with JWT
```jsonld=
{
    "username":"JohnDoe",
    "password":"azerty",
    "email":"JohnDoe@test.com"
}
```
- **POST** `/api/login_check` - Copy/Paste the JWT in header request to authenticate
```jsonld=
{
"username":"JohnDoe",
"password":"azerty"
}
```
- **POST** `/api/product/create` - Create a new product and store it inside database
```jsonld=
{
"name":"Foo",
"price":"99",
"brand":"Bar"
}
```
- **PUT** `/api/product/update/{product}` - Update a product by his ID
```jsonld=
{
"name":"Fuu",
"price":"99",
"brand":"Bar"
}
```
---
- **GET** `/api/product` - Full product's list in Json
- **GET** `/api/product/{product}` - Research and display a product by his ID
--- 
- **DELETE** `/api/product/delete/{product}` - Delete a product by his ID
---
- **EasyAdmin CRUD** `/admin` - Manage your data, in a more visual friendly way 