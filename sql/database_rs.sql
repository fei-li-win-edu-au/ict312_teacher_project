-- Create Users Table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL
);

-- Create Products Table
CREATE TABLE products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    photo VARCHAR(30),
    name VARCHAR(30),
    label VARCHAR(30),
    description VARCHAR(225),
    category CHAR(1), -- Note: For now, 'category' represents dish types: 'M' for Main dishes, 'F' for Side dishes (it suppose to be S, but in order to make as less change as possbile, we keep using F), 'D' for drinks
    attribute1 CHAR(1), -- Note: For now, 'attribute1' represents size: 'L' for Large, 'M' for Medium, 'S' for Small for now, size doesn't make any price change.
    price DECIMAL(6,2)
);

-- Create Orders Table
CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    total DECIMAL(10,2) DEFAULT 0,
    order_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(10) DEFAULT 'pending', -- Status can be 'pending' or 'completed'
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Create Order_Items Table
CREATE TABLE order_items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE RESTRICT
);

-- Insert Sample Data into Users Table
INSERT INTO users (username, password) VALUES
('user1', 'user1'),
('user2', 'user2'),
('admin', 'admin');

-- Insert Sample Data into Products Table (8 for Category 1, 8 for Category 2)
INSERT INTO products (photo, name, label, description, category, attribute1, price) VALUES
-- Category 1 Products
('c1_1.jpg', 'c1_1 name', 'c1_1 label', 'c1_1 description', 'M', 'M', 150.00),
('c1_2.jpg', 'c1_2 name', 'c1_2 label', 'c1_2 description', 'M', 'L', 200.00),
('c1_3.jpg', 'c1_3 name', 'c1_3 label', 'c1_3 description', 'M', 'S', 180.00),
('c1_4.jpg', 'c1_4 name', 'c1_4 label', 'c1_4 description', 'M', 'M', 300.00),
('c1_5.jpg', 'c1_5 name', 'c1_5 label', 'c1_5 description', 'M', 'L', 280.00),
('c1_6.jpg', 'c1_6 name', 'c1_6 label', 'c1_6 description', 'M', 'M', 120.00),
('c1_7.jpg', 'c1_7 name', 'c1_7 label', 'c1_7 description', 'M', 'L', 100.00),
('c1_8.jpg', 'c1_8 name', 'c1_8 label', 'c1_8 description', 'M', 'S', 90.00),

-- Category 2 Products
('c2_1.jpg', 'c2_1 name', 'c2_1 label', 'c2_1 description', 'F', 'S', 610.00),
('c2_2.jpg', 'c2_2 name', 'c2_2 label', 'c2_2 description', 'F', 'M', 600.00),
('c2_3.jpg', 'c2_3 name', 'c2_3 label', 'c2_3 description', 'F', 'L', 590.00),
('c2_4.jpg', 'c2_4 name', 'c2_4 label', 'c2_4 description', 'F', 'S', 400.00),
('c2_5.jpg', 'c2_5 name', 'c2_5 label', 'c2_5 description', 'F', 'M', 420.00),

-- Category 3 Products
('c3_1.jpg', 'c3_1 name', 'c3_1 label', 'c3_1 description', 'D', 'S', 610.00),
('c3_2.jpg', 'c3_2 name', 'c3_2 label', 'c3_2 description', 'D', 'M', 600.00),
('c3_3.jpg', 'c3_3 name', 'c3_3 label', 'c3_3 description', 'D', 'L', 590.00),
('c3_4.jpg', 'c3_4 name', 'c3_4 label', 'c3_4 description', 'D', 'S', 400.00);

-- Example Insert into Orders Table
INSERT INTO orders (user_id, total) VALUES
(1, 1230.00);

-- Example Insert into Order_Items Table
INSERT INTO order_items (order_id, product_id, quantity) VALUES
(1, 1, 2), -- 2 units of c1_1
(1, 9, 1), -- 1 unit of c2_1
(1, 13, 1); -- 1 unit of c2_5
