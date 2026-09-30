This project is a learning support website designed to help users improve their memory skills and develop more structured study habits.
It is especially useful for learners who study without clear direction, providing them with an organized method — or at least helping them become familiar with structured learning techniques.

🚀 Features

🧠 Memory improvement exercises

📘 Structured learning methods

🔐 Authentication (Login / Register)

🗂 CRUD functionalities (as needed)

📱 Responsive UI

⚙️ Configurable and extendable codebase

🎨 Clean and simple user interface

🛠 Installation Guide
1️⃣ Clone the Repository
git clone git@github.com:NICTruongbcn/php_project_.git
cd <your-project-folder>

2️⃣ Install Dependencies
composer install
npm install
npm run dev

3️⃣ Setup Environment File

Create a new .env file in the project root and configure it as follows:

APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

# Cache / Session / Queue
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local

MEMCACHED_HOST=127.0.0.1

# Redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"

# AWS (optional)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

4️⃣ Generate Application Key
php artisan key:generate

5️⃣ Run Migrations
php artisan migrate

6️⃣ Start the Server
php artisan serve
