CREATE DATABASE IF NOT EXISTS week2_store;
USE week2_store;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;

CREATE TABLE products (
    product_id INT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    product_description VARCHAR(255) NOT NULL,
    product_cost DECIMAL(10,2) NOT NULL
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    subtotal DECIMAL(10,2) NOT NULL,
    tax DECIMAL(10,2) NOT NULL,
    shipping DECIMAL(10,2) NOT NULL,
    order_total DECIMAL(10,2) NOT NULL
);

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    product_cost DECIMAL(10,2) NOT NULL,
    line_total DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(order_id),
    CONSTRAINT fk_order_items_product FOREIGN KEY (product_id) REFERENCES products(product_id)
);

INSERT INTO products (product_id, product_name, product_description, product_cost) VALUES
(101, 'Wireless Mouse', 'Compact wireless mouse with ergonomic grip.', 19.99),
(102, 'Mechanical Keyboard', 'Backlit keyboard with responsive mechanical keys.', 49.99),
(103, 'USB-C Hub', 'Multiport hub with HDMI, USB, and SD card support.', 34.99),
(104, 'Laptop Stand', 'Adjustable aluminum stand for laptops and tablets.', 29.99),
(105, 'Noise-Isolating Earbuds', 'Wired earbuds with clear sound and inline controls.', 24.99);
