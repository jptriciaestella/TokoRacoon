# TokoRacoon
### Made by Tricia Estella
using Laravel version 7.x

TokoRacoon is an online shop website made by PT Musang, which was done in less than a month by their one employee.

## Features
Admin:
- View all product/individual product
- Add new product
- Edit existing product
- Delete existing product
- Have all validation needed for the book information (Title, Author, Pages, YearPublished)
User:
- Login and Register account
- View all product/individual product
- Add product to cart
- Checkout


## Installation

TokoRacoon requires PHP, composer, and XAMPP to run.

Download the code and **create .env file using the data from .env.example to use configured database and other settings**.

Turn on XAMPP Apache and MySQL, **and create database named 'racoon_library' on your MySQL admin**. Then run these commands on your file terminal:

```sh
composer install
php artisan key:generate
php artisan migrate
```

To create product categories and admin data, please do:
```sh
php db:seed
```

For storage configuration, please do:

```sh
php artisan storage:link
```

And all features should work normally, type:

```sh
php artisan serve
```

You can do CRUD for the product using admin account, which is:
email: admin@gmail.com
pw: admin

