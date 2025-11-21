## E-commerce API — Laravel Backend
 
#### A clean and E-commerce REST API built with Laravel 12, featuring:


🔐 User Authentication

📦 Product management

🛒 Cart System

🧾 Checkout & Orders

📄 Auto-Generated API Docs using Scramble

🧱 Service-based Architecture for Clean Code

## 🚀 Tech Stack

#### Laravel 12 

#### PHP 8.2+

#### MySQL

#### Laravel Scramble

## Note : 

#### Laravel Scramble acts as a lightweight alternative to Postman, providing an easy-to-use in-browser API playground where you can explore, test, and interact with your endpoints directly without any external tools.

## DB Diagram :

https://dbdiagram.io/d/6920e341228c5bbc1afa2535

## 🔧 Installation & Setup

Follow these steps to run the project locally:

#### 1️⃣ Clone the repository
git clone https://github.com/mohamed-ghareeb/ecommerce-task 

cd your-repo

#### 2️⃣ Install dependencies

composer install

#### 3️⃣ Configure environment 

cp .env.example .env


#### Generate application key:

php artisan key:generate


Update .env with your database credentials.

#### 4️⃣ Migrate & Seed database

php artisan migrate --seed

#### 5️⃣ Start the server
php artisan serve

#### 📘 API Documentation and Usage (Scramble)

This project uses Laravel Scramble to automatically generate API documentation.

#### ✔️ Step 1 — Analyze routes
php artisan scramble:analyze

#### ✔️ Step 2 — Export documentation
php artisan scramble:export

#### ✔️ Access the generated docs

After exporting, open:

http://localhost:8000/docs/api#/
