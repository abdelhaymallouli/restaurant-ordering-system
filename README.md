# 🍽️ Restaurant Ordering System

![Project Status](https://img.shields.io/badge/status-active-brightgreen)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1)

> A comprehensive web-based solution for seamless food ordering and restaurant management.



## 📖 Project Overview

The **Restaurant Ordering System** is a web-based application designed to streamline the food ordering process. It allows customers to browse a menu, place orders, and track their delivery status. Administrators have a dedicated dashboard to manage orders, clients, and menu items efficiently.

## ✨ Features

### 👤 User Features

- **Authentication**: Users can sign up and log in to access the system.
- **Visual Menu**: Browse dishes with mouth-watering images and detailed descriptions.
- **Smart Filtering**: Filter dishes by category (Starter, Main Course, Dessert) and cuisine (Moroccan, Italian, Chinese, etc.).
- **Cart Management**: Add items to the shopping cart and manage quantities.
- **Order Placement**: Simple checkout process to place orders.

### 🛡️ Admin Features

- **Dashboard**: Real-time insights into today's orders, total clients, and sales performance.
- **Order Management**: View all orders placed today with details (Customer Name, Date, Status).
- **Status Updates**: Update order status (Pending, In Progress, Shipped, Delivered, Canceled) with a single click.
- **Client Management**: View list of registered clients.

## 🛠️ Technology Stack

- **Backend**: PHP (Native)
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Server**: Apache (via XAMPP/WAMP)

## 🗄️ Database Schema

The database `solirestaurant` consists of three main tables:

| Table           | Description                                                |
| --------------- | ---------------------------------------------------------- |
| `client`        | Stores customer details (Name, Phone, ID).                 |
| `plat`          | Stores menu items (Name, Category, Cuisine, Price, Image). |
| `commande`      | Stores order details (Date, Status, Customer ID).          |
| `commande_plat` | Linking table for Orders and Dishes (Quantity).            |

## 📂 File Structure

- `index.php`: Main landing page with menu and ordering functionality.
- `admin.php`: Admin dashboard for managing orders.
- `config.php`: Database connection settings.
- `login.php` / `sign-in.php`: User authentication pages.
- `checkout.php`: Handles the final order processing.
- `frontend/`: Contains CSS, JS, and image assets.


#screenshots

![Restaurant Ordering System Screenshot](screenshots/screenshot.png)

## 🚀 Installation & Setup

### Prerequisites

- **XAMPP** or **WAMP** Server installed.
- A web browser.

### Steps

1. **Clone the repository** to your server's root directory (e.g., `C:\xampp\htdocs\restaurant-ordering-system`).
   ```bash
   git clone https://github.com/yourusername/restaurant-ordering-system.git
   ```
2. **Start Servers**: Open XAMPP Control Panel and start **Apache** and **MySQL**.
3. **Setup Database**:
   - Go to `http://localhost/phpmyadmin`.
   - Create a new database named `solirestaurant`.
   - Click **Import** and select the `solirestaurant.sql` file from the project folder.
4. **Configure**:
   - Ensure `config.php` has the correct database credentials (default is user: `root`, password: empty).
5. **Run**:
   - Open your browser and visit: `http://localhost/restaurant-ordering-system/`

---

_Created with ❤️ by [Your Name]_
