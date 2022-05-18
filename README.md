# TokoRacoon
### Made by Tricia Estella
using Laravel version 7.x

TokoRacoon is an online shop website made by PT Musang, which was done in less than a month by their one employee. In TokoRacoon, we sell everything, including poison.

## Features
### Admin:
- View all product/individual product
- Add new product
- Edit existing product
- Delete existing product
- Have all validation needed for the product information
- View all order received from users
- View order details (invoice)
- Deliver the order

### User:
- Login and Register account
- View all product/individual product
- Add product to cart
- Update product quantity in cart
- Delete product in cart
- Checkout
- View all order they made
- View order details (invoice)
- Complete the order

### Other features:
- Product cannot be added to cart once it is sold out
- You can't have more product in your cart than what's available in the database
- Added 11% tax per purchase for more complexity and CUAN
- Prooduct stock automatically decreased once user check-out the product
- Order status: In Progress, In Delivery, Completed

## Important Notice!!
It's better to update the product stock then to delete the product completely, as deleting the product may affect order details. The order will show the correct Subtotal, Tax, and Total, but not all of the product listed if one of it is deleted.

## Installation

TokoRacoon requires PHP, composer, and XAMPP to run.

Download the code and **create .env file using the data from .env.example to use configured database and other settings**.

Turn on XAMPP Apache and MySQL, **and create database named 'tokoracoon' on your MySQL admin**. Then run these commands on your file terminal:

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

You can do CRUD for the product using admin account, which is:<br />
email: admin@gmail.com<br />
pw: admin

