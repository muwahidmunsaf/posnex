# Irshad Autos POS System

A modern, full-featured Point of Sale (POS) and business management web application for retailers, distributors, and shopkeepers. Built with Laravel, it streamlines sales, inventory, HR, reporting, and backup operations for small and medium businesses.

---

## 🚀 Features

- **Sales & POS**
  - Create and manage sales (retail, wholesale, distributor)
  - Manual sales record entry
  - Sales receipts and after-sale operations
  - Returns and exchanges management
- **Inventory Management**
  - Add, edit, and track inventory items
  - Stock entry and purchase management
  - Low-stock alerts
- **Supplier & Customer Management**
  - Manage suppliers and customers
  - Supplier payments and customer transactions
- **Distributor & Shopkeeper Management**
  - Assign products to distributors
  - Track shopkeeper transactions
  - Distributor payments and product assignments
- **HR & Employee Management**
  - Employee records and salary payments
  - Bulk salary processing
- **Expense Tracking**
  - Record and categorize business expenses
- **Comprehensive Reporting**
  - Stock, purchase, sales, finance, and invoice reports
  - Daily sales and profit analytics
  - External sales and purchases reports
- **User & Role Management**
  - Admin, manager, and employee roles
  - Permissions-based access control
- **Activity Logging & Audit Trail**
  - Logs all key actions (CRUD, login/logout, payments, reports, backups)
  - Recycle bin for deleted records
- **Backup & Restore**
  - Downloadable CSV/XLSX backups for all modules
  - Full database and file backup/restore
  - Google Drive cloud backup integration
- **Other**
  - Multi-company support
  - Modern, responsive UI
  - Secure authentication and session management

---

## 🛠️ Installation & Setup

### Requirements
- PHP 8.2+
- Composer
- MySQL/MariaDB (or compatible DB)
- Node.js & npm (for asset compilation, if needed)
- [Optional] Docker

### Environment Variables
Copy `.env.example` to `.env` and set:
- `APP_KEY` (generate with `php artisan key:generate`)
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_DRIVE_REFRESH_TOKEN`, `GOOGLE_DRIVE_FOLDER_ID` (for cloud backup)
- Mail, cache, and other service credentials as needed

### Local Setup
1. Clone the repo and `cd` into the project directory
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install JS dependencies (if using asset pipeline):
   ```bash
   npm install && npm run build
   ```
4. Set up your `.env` file and database
5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```
6. Start the server:
   ```bash
   php artisan serve
   ```

### Docker Setup
- Build and run with Docker:
  ```bash
  docker build -t irshad-autos-pos .
  docker run -p 8080:8080 irshad-autos-pos
  ```
- The container will auto-run migrations and seeders, and serve the app on port 8080.

---

## 📊 Demo Data
- The system includes seeders for demo users, companies, inventory, and more.
- Login as admin, manager, or employee to explore different roles.

---

## 📝 License
This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👨‍💻 Developed by [DevZyte](https://devzyte.com)
For support or customizations, contact info@devzyte.com or (+92) 346-7911195.
