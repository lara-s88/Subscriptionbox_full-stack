CREATE DATABASE IF NOT EXISTS sportbox_db
CHARACTER SET utf8mb4

USE sportbox_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    status ENUM('active', 'paused', 'blocked')  DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    diet_preference VARCHAR(100) NULL,
    skill_level VARCHAR(50) NULL,
    address_line VARCHAR(190) NULL,
    city VARCHAR(100) NULL,
    country VARCHAR(100) NULL,
    delivery_instructions TEXT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE user_allergies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    allergy_name VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    price_monthly DECIMAL(10,2) NOT NULL,
    boxes_per_month INT NOT NULL DEFAULT 1,
    swap_limit INT NULL,
    express_shipping TINYINT(1) NOT NULL DEFAULT 0,
    early_access TINYINT(1) NOT NULL DEFAULT 0,
    vip_support TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    plan_id INT NOT NULL,
    status ENUM('active', 'paused', 'cancelled', 'pending') NOT NULL DEFAULT 'pending',
    next_billing_date DATE NULL,
    last_billing_date DATE NULL,
    pause_until DATE NULL,
    started_at DATE NULL,
    renewal_day INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (plan_id) REFERENCES plans(id)
);

CREATE TABLE themes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    month_label VARCHAR(50) NOT NULL,
    status ENUM('draft', 'uploaded', 'ready', 'archived') NOT NULL DEFAULT 'draft',
    description TEXT NULL,
    banner_image VARCHAR(255) NULL,
    created_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE boxes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    theme_id INT NULL,
    name VARCHAR(150) NOT NULL,
    box_type VARCHAR(80) NOT NULL,
    base_price DECIMAL(10,2) NOT NULL,
    base_image VARCHAR(255) NULL,
    description TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE SET NULL
);

CREATE TABLE inventory_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    theme_id INT NULL,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    stock_qty INT NOT NULL DEFAULT 0,
    safety_threshold INT NOT NULL DEFAULT 0,
    unit_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    weight_kg DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE SET NULL
);

CREATE TABLE box_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    box_id INT NOT NULL,
    inventory_item_id INT NOT NULL,
    is_part_of_box TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (box_id) REFERENCES boxes(id) ON DELETE CASCADE,
    FOREIGN KEY (inventory_item_id) REFERENCES inventory_items(id) ON DELETE CASCADE
);

CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    box_id INT NOT NULL,
    custom_size VARCHAR(20) NULL,
    diet_preference VARCHAR(100) NULL,
    shipping_status ENUM( 'pending_confirmation', 'shipping_confirmed','shipped') NOT NULL DEFAULT 'pending_confirmation',
    subtotal DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (box_id) REFERENCES boxes(id) ON DELETE CASCADE
);

CREATE TABLE cart_item_extra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_item_id INT NOT NULL,
    inventory_item_id INT NULL,
    item_name VARCHAR(150) NOT NULL,
    source_type ENUM( 'default',  'swap', 'addon', 'surprise') NOT NULL DEFAULT 'default',
    unit_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cart_item_id) REFERENCES cart_items(id) ON DELETE CASCADE,
    FOREIGN KEY (inventory_item_id) REFERENCES inventory_items(id) ON DELETE SET NULL
);
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subscription_id INT NULL,
    cart_item_id INT NULL,
    order_number VARCHAR(50) NOT NULL UNIQUE,
    status ENUM('pending', 'picking', 'packed', 'shipped', 'out_for_delivery', 'delivered', 'returned') NOT NULL DEFAULT 'pending',
    total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    shipping_fee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    confirmed_at DATETIME NULL,
    shipped_at DATETIME NULL,
    delivered_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subscription_id) REFERENCES subscriptions(id) ON DELETE SET NULL,
    FOREIGN KEY (cart_item_id) REFERENCES cart_items(id) ON DELETE SET NULL
);

CREATE TABLE shipping_batches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    batch_code VARCHAR(50) NOT NULL UNIQUE,
    region VARCHAR(100) NOT NULL,
    warehouse_state ENUM('picking', 'packed', 'shipped') NOT NULL DEFAULT 'picking',
    scheduled_ship_date DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE shipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    batch_id INT NULL,
    tracking_code VARCHAR(80) NOT NULL UNIQUE,
    carrier_name VARCHAR(100) NULL,
    status ENUM('pending', 'picking', 'packed', 'shipped', 'out_for_delivery', 'delivered') NOT NULL DEFAULT 'pending',
    estimated_delivery DATE NULL,
    stops_away INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (batch_id) REFERENCES shipping_batches(id) ON DELETE SET NULL
);

CREATE TABLE returns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('requested', 'approved', 'rejected', 'completed') NOT NULL DEFAULT 'requested',
    photo_path VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE TABLE reward_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    points INT NOT NULL DEFAULT 0,
    tier_name VARCHAR(50) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE reward_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    points_used INT NOT NULL,
    source_type VARCHAR(80) NOT NULL,
    source_id INT NULL,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
