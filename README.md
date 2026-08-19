# Boutique Management System

A full-stack e-commerce web application built with PHP and MySQL to handle product inventory, session-based shopping carts, secure checkout pipelines, and order tracking.

---

## 🛠️ Tech Stack & Prerequisites

* **Frontend:** HTML5, CSS3, JavaScript
* **Backend:** PHP (Native / Procedural)
* **Database:** MySQL / phpMyAdmin
* **Server Environment:** XAMPP / WAMP / Apache

---

## 🚀 Quick Setup Guide

1. **Move Project Files:** Place the repository folder inside your local server directory (`htdocs/boutique-management-system`).
2. **Database Setup:** 
   * Open **phpMyAdmin** and create a database named `boutique_db`.
   * Import the SQL schema queries provided in `schema.txt`.
3. **Database Credentials:** Ensure `db.php` has correct connection parameters (`localhost`, `root`, ``, `boutique_db`).
4. **Launch:** Start Apache & MySQL in XAMPP and navigate to `http://localhost/boutique-management-system/index.php`.

---

## ✨ Core Features

* **Authentication & Security:** User Signup, Login, Session Persistence, Logout (`logout.php`), and Protected Routes (`addproduct.php`, `checkout.php`).
* **Catalog & Product Management:** Dynamic MySQL-driven CRUD operations for inventory listing and management.
* **Shopping Cart System:** Session-persistent cart synced with a global navbar counter (`navbar.php`).
* **Relational Order Processing:** Multi-table checkout pipeline saving order records to `orders` and `order_items` tables.

---

## 🛠️ Weekly Log & Debugging Highlights

* **Schema Foreign Key Alignment:** Resolved missing database column errors (`Unknown column 'email'`) by executing defensive table schema scripts.
* **Route Protection:** Enforced session guard checks (`session_start()`, `$_SESSION['user_id']`) at script heads to block unauthorized URL access.
* **Navbar State Synchronization:** Replaced static headers with a dynamic `navbar.php` component using `array_sum()` for realtime cart item counts.
* **Transactional Checkout Handling:** Integrated MySQLi prepared statements to process sequential relational inserts during checkout.

---

## 👥 Project Collaborators


 **Natasha**
