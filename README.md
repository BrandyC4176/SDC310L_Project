# Week 2 PHP Store Project

This Week 2 version gives you:
- a basic textual catalog with 5 products
- a working shopping cart
- add / remove / quantity update / checkout
- navigation between catalog and cart
- a MySQL database script you can import now
- PHP framework files ready for Week 3 database integration

## Folder structure
- `index.php` - catalog page
- `cart.php` - shopping cart page
- `checkout.php` - checkout action
- `includes/header.php` - shared page header
- `includes/footer.php` - shared footer
- `includes/products.php` - starter product data for Week 2
- `includes/functions.php` - cart helper functions
- `css/style.css` - store styling
- `database/store.sql` - database schema and sample products for later use

## What this covers for Week 2
Week 2 focuses on:
1. Creating the database structure
2. Building the application framework
3. Creating the pages and reusable layout
4. Demonstrating the basic shopping flow

For Week 2, products are loaded from `includes/products.php` so your project works immediately.
In Week 3, you can replace that with MySQL queries from the `products` table.

## How to run it with XAMPP
1. Install XAMPP.
2. Start Apache.
3. Place the `week2_store` folder inside `C:\xampp\htdocs\`
4. Open `http://localhost/week2_store/`

## How to import the database
1. Start MySQL in XAMPP.
2. Open phpMyAdmin.
3. Create a database named `week2_store`.
4. Click the new database.
5. Choose Import.
6. Import the file `database/store.sql`.

## What to submit for Week 2
- updated project plan
- link to your GitHub repository
- your code files
