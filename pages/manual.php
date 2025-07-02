<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
?>

<style>
    #main-content {
        margin-left: 250px;
        padding: 90px 40px 80px;
        background: #f0f4f8;
        min-height: 100vh;
        transition: margin-left 0.3s ease;
    }

    body.sidebar-collapsed #main-content {
        margin-left: 80px;
    }

    .tabs {
        display: flex;
        border-bottom: 2px solid #1a374d;
        margin-bottom: 20px;
        cursor: pointer;
    }

    .tab {
        padding: 12px 24px;
        font-weight: 600;
        color: #1a374d;
        border: 2px solid transparent;
        border-bottom: none;
    }

    .tab.active {
        border-color: #1a374d #1a374d white;
        background: white;
        border-radius: 8px 8px 0 0;
    }

    .tab-content {
        background: white;
        border: 2px solid #1a374d;
        border-radius: 0 8px 8px 8px;
        padding: 20px;
        min-height: 300px;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        color: #1a374d;
        line-height: 1.6;
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    pre {
        background: #e9eff4;
        padding: 15px;
        border-radius: 6px;
        overflow-x: auto;
        font-size: 14px;
    }

    h3 {
        margin-top: 0;
    }
</style>

<div id="main-content">
    <h2>📘 Project Manual</h2>
    <p>This manual covers the entire Cafeteria System: technologies, setup, file structure, DB schema, system logic, and customization notes.</p>

    <div class="tabs">
        <div class="tab active" data-tab="overview">Overview</div>
        <div class="tab" data-tab="tech">Technologies</div>
        <div class="tab" data-tab="files">File Structure</div>
        <div class="tab" data-tab="clone">Clone & Setup</div>
        <div class="tab" data-tab="system">System Details</div>
        <div class="tab" data-tab="crud">CRUD & Logic</div>
        <div class="tab" data-tab="schema">Database Schema</div>
        <div class="tab" data-tab="custom">Customization</div>
    </div>

    <div class="tab-content active" id="overview">
        <h3>Project Overview</h3>
        <p>This is a full-stack PHP + MySQL application for managing cafeteria workflows like menu management, orders, users, and customers.</p>
    </div>

    <div class="tab-content" id="tech">
        <h3>Technologies Used</h3>
        <ul>
            <li>PHP (7/8) + MySQLi</li>
            <li>MySQL with foreign key support</li>
            <li>Vanilla JavaScript</li>
            <li>HTML5 / CSS3 + FontAwesome</li>
            <li>Google Fonts - Poppins</li>
        </ul>
    </div>

    <div class="tab-content" id="files">
        <h3>File Structure</h3>
        <pre>
/cafeteria-system/
├─ /assets/               # Logos & static media
├─ /includes/             # Reusable components (header, sidebar)
├─ /modules/              # Backend handlers (add, edit, delete)
├─ /pages/                # UI pages like dashboard, users, menu
├─ /uploads/              # Uploaded profile images
├─ db.php                 # Database connection
├─ index.php              # Login page
        </pre>
    </div>

    <div class="tab-content" id="clone">
        <h3>How to Clone & Setup</h3>
        <ol>
            <li><code>git clone https://github.com/yourusername/cafeteria-system.git</code></li>
            <li>Import the provided SQL schema into MySQL.</li>
            <li>Edit <code>includes/db.php</code> with your DB credentials.</li>
            <li>Ensure <code>/uploads/profile_pics</code> is writable.</li>
            <li>Run: <code>http://localhost/cafeteria-system/pages/login.php</code></li>
        </ol>
    </div>

    <div class="tab-content" id="system">
        <h3>System Details</h3>
        <ul>
            <li><strong>Login</strong>: Processes credentials via <code>index.php</code> and sets <code>$_SESSION['user']</code></li>
            <li><strong>Authentication</strong>: Protected pages check session before access</li>
            <li><strong>Sidebar</strong>: Role-based rendering in <code>includes/sidebar.php</code></li>
            <li><strong>Logout</strong>: <code>logout.php</code> destroys session</li>
            <li><strong>Header</strong>: Displays user info</li>
        </ul>
    </div>

    <div class="tab-content" id="crud">
        <h3>CRUD & Logic</h3>
        <ul>
            <li><code>modules/add_item.php</code>: Create item</li>
            <li><code>modules/edit_item.php</code>: Update item</li>
            <li><code>modules/delete_item.php</code>: Delete item</li>
            <li><code>modules/profile.php</code>: Profile image logic</li>
            <li>All forms use <code>POST</code> and <code>mysqli prepared statements</code></li>
        </ul>
    </div>

    <div class="tab-content" id="schema">
        <h3>Database Schema</h3>
        <pre>
CREATE DATABASE cafeteria_db;
USE cafeteria_db;

-- USERS
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'staff',
    profile_pic VARCHAR(255)
);

-- MENU
CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    available TINYINT(1) DEFAULT 1
);

-- CUSTOMERS
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100)
);

-- ORDERS
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    total DECIMAL(10,2),
    order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
);

-- ORDER ITEMS
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    menu_id INT,
    qty INT DEFAULT 1,
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE SET NULL
);
        </pre>
    </div>

    <div class="tab-content" id="custom">
        <h3>Customization Tips</h3>
        <ul>
            <li>Change the project name/logo in <code>assets/logo.jpg</code></li>
            <li>Add new roles by extending the <code>users.role</code> column</li>
            <li>Extend order logic to allow payment methods or delivery options</li>
            <li>Reset demo data via:
                <pre>TRUNCATE orders; TRUNCATE order_items; TRUNCATE customers;</pre>
            </li>
        </ul>
    </div>
</div>

<script>
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById(tab.getAttribute('data-tab')).classList.add('active');
        });
    });
</script>

<?php include_once '../includes/footer.php'; ?>