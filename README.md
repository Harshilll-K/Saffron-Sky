# Saffron Sky 🍕🍔🍣

Saffron Sky is a premium, feature-rich food ordering and delivery web application designed to connect foodies with their favorite meals. Built using PHP, MySQL, and styled with high-end, responsive custom CSS and TailwindCSS, this platform provides an exceptional user experience alongside a robust back-office admin dashboard.

---

## ✨ Features

### 🖥️ Customer Portal (`finalfoody`)
* **Responsive Homepage**: Modern, glassmorphism-styled navigation bar, vibrant layouts, and hover effects that look great on desktop, tablet, and mobile.
* **Interactive AI Chatbot**: Built-in support chatbot offering food recommendations and instant assistance to customers right from the homepage.
* **Menu & Special Deals**: Beautiful layout showing available meal boxes, regular menu items, and timed discount deals.
* **Shopping Cart & Checkout**: Add, remove, and manage cart quantities seamlessly before checking out.
* **Order History & Delivery Details**: A customer dashboard to view past orders and manage active deliveries (`past_orders.php`, `save_delivery.php`).

### ⚙️ Admin Control Panel (`admin`)
* **Live Order Control**: Admins can monitor, update, and process active customer orders in real-time (`admin/orders.php`).
* **Interactive Dashboard**: A dedicated home space for analytics, revenue reports, and user counts (`admin/dashboard.php`).
* **Menu Management**: Control available food dishes, prices, categories, and special promotions.

### 🗄️ Database & Installation
* **Auto Table Setup**: Includes dedicated PHP scripts (`create_all_tables.php`, `create_order_tables.php`, `create_delivery_table.php`) to automatically generate database schemas, saving time on setup.

---

## 🛠️ Technologies Used

* **Backend**: PHP (v8.x recommended)
* **Frontend**: HTML5, Vanilla CSS, TailwindCSS (via CDN), JavaScript
* **Database**: MySQL / MariaDB
* **Icons**: FontAwesome v6.0
* **Deployment**: Pre-configured for deployment on **Vercel** via community PHP runtime.

---

## 🚀 Getting Started

### Local Development (XAMPP / WAMP)
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/your-username/saffron-sky.git
   ```
2. **Move to Server Root**:
   Move the folder to your `htdocs` (XAMPP) or `www` (WAMP) folder.
3. **Database Configuration**:
   * Open `http://localhost/phpmyadmin`.
   * Create a new database named `saffron_sky`.
   * Run the database creation script by opening `http://localhost/saffron-sky/finalfoody/create_all_tables.php` in your browser. This will automatically generate all necessary tables!
4. **Update Connection Settings**:
   * Edit `finalfoody/connect_food.php` or `connect.php` with your local database username and password.

---

## ☁️ Deployment on Vercel

This repository includes a `vercel.json` file which enables serverless PHP execution on the Vercel platform.

1. **Host Database Online**: Export your local SQL database and upload it to a free cloud provider like **Aiven**, **TiDB Serverless**, or **Supabase**.
2. **Update Connection Info**: Update the credentials in `connect.php` / `connect_food.php` to point to your new cloud database host.
3. **Push to GitHub**: Push your local repository to GitHub.
4. **Deploy**: Import the GitHub repo into [Vercel](https://vercel.com/) and let Vercel handle the rest!

---

## 📄 License
This project is open-source and available under the MIT License.
