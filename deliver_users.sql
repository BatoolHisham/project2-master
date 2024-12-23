CREATE TABLE deliver_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    location VARCHAR(255), -- Delivery location
    status ENUM('available', 'busy', 'offline') NOT NULL, -- Delivery status
    assigned_orders INT, -- Number of orders assigned
    FOREIGN KEY (assigned_orders) REFERENCES orders(order_id) -- Assuming there’s an order table
);
