📦 E-commerce API — Laravel Backend

This is a simple e-commerce backend built using Laravel 11, implementing features such as:

User authentication

Products & categories

Cart management

Checkout process

API documentation using Scramble

Clean service-based architecture

🚀 Tech Stack

Laravel 11

MySQL

Scramble for API documentation

Pest / PHPUnit (optional)

PHP 8.2+

🔧 Installation & Setup
1️⃣ Clone the project
git clone https://github.com/mohamed-ghareeb/your-repo.git
cd your-repo

2️⃣ Install dependencies
composer install

3️⃣ Environment setup

Duplicate .env.example:

cp .env.example .env


Generate application key:

php artisan key:generate


Configure database credentials in .env.

4️⃣ Run migrations & seeders
php artisan migrate --seed

5️⃣ Start the server
php artisan serve

📘 API Documentation (Scramble)

This project uses Laravel Scramble to generate beautiful API documentation.

✔️ Generate documentation

Before exporting the docs, Scramble must analyze your routes:

php artisan scramble:analyze


Then export the final documentation:

php artisan scramble:export

✔️ Access API docs

After exporting, the documentation will be available at:

/docs


Or inside:

public/docs/index.html
