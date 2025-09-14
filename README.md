
PHP-ASSINGMENT: including backend (Laravel 10) and frontend (Vue 3) for managing emails, users, and daily report

---

## 1. Requirements

- PHP >= 8.2
- Composer
- Node.js & npm
- PostgreSQL 17
- XAMPP
- SMTP configuration for sending emails

---

## 2. Setup Backend (Laravel)

1. **Clone repo and install dependencies**

```bash
git clone https://github.com/chungvn14/php-assignment.git
cd php-assignment
composer install
````

2. **Configure environment**

```bash
cp .env.example .env
```

* Update DB settings (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
* Configure mail settings (`MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, etc.)
* Configure admin email in `.env`: admin +user .env file

```
ADMIN_EMAIL=admin@example.com
```

3. **Run migrations & seeders**

```bash
php artisan migrate:fresh --seed
```

4. **Start backend server**

```bash
php artisan serve
```

By default, it runs at [http://localhost:8000](http://localhost:8000)

---

## 3. Setup Frontend (Vue 3)

The frontend has **two configurations**: admin and user.

1. **Install dependencies**

```bash
cd resources/assets/admin
npm install
```

2. **Run frontend with config files**

* **Admin interface**:

```bash
npx vite --config vite.admin.config.js
```

* **User interface**:

```bash
npx vite --config vite.user.config.js
```

3. **Access frontend**

* Admin: [http://localhost:5173](http://localhost:5173) (default Vite port, adjust if needed)
* User: [http://localhost:5174](http://localhost:5174) (different port for user)
-> SHOULD RUN ON localhost:8000 for be+fe
---

## 4. Queue Worker

The system uses Laravel queues for email sending and daily reports.

Run queue worker:

```bash
php artisan queue:work
```

## 5. Default Credentials

* **Admin**: seeded in the database
* **User**: seeded in the database or via registration form

> After registration, login and the system will route based on user role.
Account admin: admin@gmail.com - password:admin123
Account user: user@gmail.com - password:user123
---

## 6. Notes

* Ensure `storage/` and `bootstrap/cache/` are writable
* Run queue worker before sending emails to avoid 500 errors
* Daily reports are automatically generated via scheduled commands
* Frontend routes are protected by role-based auth (meta: `role: 'admin'` or `'user'`)

---

## 7. Common Commands

```bash
# Backend
php artisan migrate:fresh --seed
php artisan serve
php artisan queue:work

# Frontend
npx vite --config vite.admin.config.js
npx vite --config vite.user.config.js
```

