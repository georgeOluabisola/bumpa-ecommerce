# E-Commerce Loyalty Program - Assessment

A full-stack implementation of an e-commerce loyalty program where customers unlock achievements and earn badges for their purchases. Built with Laravel and React with event-driven architecture.

## 📋 Project Overview

This project implements a complete loyalty program system with:

- **Backend**: Achievement, Payment and badge logic built with event-driven architecture using Laravel
- **Frontend**: Responsive customer dashboard built with React, InertiaJS and Laravel official starter Kit, consuming RESTful APIs
- **Database**: SQLite (default) or MySQL/PostgreSQL for production
- **Real-time Events**: Event listeners that fire when achievements/badges are unlocked
- **Payment Integration**: Mock cashback payment processor for badge unlocks using Logs.

## 🛠 Tech Stack

### Backend

- **Backend Framework**: Laravel 12 with Inertia.js
- **Language**: PHP 8.2+
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Event System**: Laravel Events & Listeners
- **Authentication**: Laravel Sanctum
- **Testing**: Pest

### Frontend

- **Framework**: React 18+ with TypeScript
- **Build Tool**: Vite 5+
- **CSS**: Tailwind CSS 4 with @tailwindcss/vite
- **UI Components**: Radix UI (Headless components)
- **HTTP Client**: Axios
- **Animation**: Framer Motion
- **Routing**: Inertia.js with React adapter
- **Linting**: ESLint + Prettier

### Additional Tools

- **Package Manager**: NPM, Composer
- **Code Formatting**: Prettier, Pint (PHP)
- **Testing**: Pest (Laravel), Vitest (JavaScript)

## 📦 Prerequisites

Before you begin, ensure you have installed:

- **Node.js** 18+ (with npm) - [Download](https://nodejs.org)
- **PHP** 8.2+ - [Download](https://www.php.net/downloads)
- **Composer** 2.x - [Download](https://getcomposer.org)
- **Git** - [Download](https://git-scm.com)
- **SQLite 3** (usually included) OR **MySQL 8.0+** / **PostgreSQL 12+** for production

### System Requirements

- **Windows**: Windows 10/11 with WSL2 (recommended) or native PHP
- **macOS**: macOS 10.15+ with Homebrew
- **Linux**: Any modern Linux distribution

Verify installations:

```bash
php --version
node --version
composer --version
npm --version
```

## 🚀 Getting Started

### Quick Start

#### 1. Clone the project

```bash
git clone https://github.com/georgeOluabisola/bumpa-ecommerce.git
```

#### 2. navigate to the project

```bash
cd bumpa-app(the name of the project)
```

#### 3. Install dependencies

```bash
composer install
npm install
```

#### 4. Copy the example environment file

```bash
cp .env.example .env # macOS/Linux
copy .env.example .env # Windows (Command Prompt)
```

#### 5: Generate Application Key

Generate Application Key

```bash
php artisan key:generate
```

#### 6: Configure Database (Optional)

**Option A: Use SQLite (Default - No Setup Needed)**
The project uses SQLite by default. The `.env` file has:

```
DB_CONNECTION=sqlite
```

**Option B: Use MySQL**

1. Create a new database:

    ```bash
    mysql -u root -p
    CREATE DATABASE bumpa_loyalty;
    EXIT;
    ```

2. Update `.env`:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=bumpa_loyalty
    DB_USERNAME=root
    DB_PASSWORD=your_password
    ```

**Option C: Use PostgreSQL**

1. Create a new database:

    ```bash
    createdb bumpa_loyalty
    ```

2. Update `.env`:
    ```env
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=bumpa_loyalty
    DB_USERNAME=postgres
    DB_PASSWORD=your_password
    ```

#### 7: Run Database Migrations

```bash
php artisan migrate
```

This creates the following tables:

- `users` - User accounts
- `achievements` - Available achievements
- `badges` - Available badges
- `achievement_users` - User achievement progress
- `badge_users` - User badge progress
- `purchases` - User purchase records
- `sessions` - Session management
- `cache` - Cache storage
- `jobs` - Queue jobs

#### 8: Seed Sample Data

```bash
php artisan db:seed
```

This populates the database with:

- Sample achievements (First Purchase, 5 Purchases, 10 Purchases, etc.)
- Sample badges (Bronze, Silver, Gold, Platinum)
- Test user account (for development)

**Verify success**:

```bash
php artisan tinker
>>> App\Models\Achievement::all()
>>> App\Models\Badge::all()
>>> exit
```

#### 9. Start servers (Option A. in separate terminals)

```bash
php artisan serve # Terminal 1
npm run dev # Terminal 2
```

#### 10. Start servers (Option B. Using a combined commands)

```bash
comsposer run dev # it will run both php artisan serve and npm run dev a the same time
```

Then open your browser to `http://localhost:8000/dashboard`

---

### Accessing the Application

**Important**: You must be logged in to see the dashboard.

#### Step 1: Setup or use an already exisiting user account

**Option A: Use an already exisiting user Account**

1. Open browser to `http://localhost:8000`
2. Click "Login" or go to "/login"
3. Fill in the details:
    - Name: Bumpa
    - Email: bumpa@gmail.com
    - Password: 09061577006
4. Click "Login"

**Option B: Create a User Account**

1. Open browser to `http://localhost:8000`
2. Click "Register" or go to `/register`
3. Fill in registration form:
    - Email: bumpa@gmail.com
    - Password: 09061577006

4. Click "Register"

#### Step 2: Access Dashboard

- You'll be redirected to the dashboard automatically
- Or visit `http://localhost:8000/dashboard`

**What you'll see:**

- Total Purchase count
- Current Badge (e.g., "Silver")
- Progress bar to next badge
- Unlocked Achievements list
- Next Available Achievements list

#### Step 3: Make Test Purchases

- You can use the "Make Purchase" button to add purchases
- This triggers the achievement/badge unlock logic
- Dashboard updates in real-time

---

### Building for Production

#### Build Frontend Assets

```bash
npm run build
```

**Output**: Creates `public/build/` directory with optimized assets

#### Prepare Laravel for Production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Deploy

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

## 🏗 Backend Architecture

### Event-Driven Flow

```
Purchase Created
    ↓
PurchaseMade Event
    ↓
AwardAchievement Listener
    ↓
Check Achievements by Purchase Count
    ↓
AchievementUnlocked Event (if earned)
    ↓
AwardBadge Listener
    ↓
Check Badges by Achievement Count
    ↓
BadgeUnlocked Event (if earned)
    ↓
AwardBadgeCashbackPayment Listener
    ↓
Process 300 Naira Cashback Payment
```

### Key Services

#### AchievementService

- **Location**: `app/Services/AchievementService.php`
- **Responsibilities**:
    - Determine which achievements a user qualifies for
    - Award achievements based on purchase count
    - Fire `AchievementUnlocked` events

#### BadgeService

- **Location**: `app/Services/BadgeService.php`
- **Responsibilities**:
    - Determine which badges a user qualifies for
    - Award badges based on achievement count
    - Calculate remaining achievements needed for next badge
    - Track active/inactive badge status

#### BadgeCashbackPaymentService

- **Location**: `app/Services/BadgeCashbackPaymentService.php`
- **Responsibilities**:
    - Process cashback payments (currently logged)
    - Payment amount: 300 Naira per badge unlock
    - Can be extended to integrate with actual payment providers

### Models

#### User

- Has many achievements (through `AchievementUser`)
- Has many badges (through `BadgeUser`)
- Has many purchases

#### Achievement

- Belongs to many users
- Properties: `name`, `achievements_required`

#### Badge

- Belongs to many users
- Properties: `name`, `achievements_required`

#### Purchase

- Belongs to user
- Triggers achievement evaluation

#### AchievementUser (Pivot)

- Links users to achievements
- Tracks when achievement was earned

#### BadgeUser (Pivot)

- Links users to badges
- Tracks: `is_active`, timestamps

### Database Schema

```sql
-- Achievements Table
CREATE TABLE achievements (
  id, name, achievements_required, created_at, updated_at
);

-- Badges Table
CREATE TABLE badges (
  id, name, achievements_required, created_at, updated_at
);

-- Achievement Users (Pivot)
CREATE TABLE achievement_users (
  id, user_id, achievement_id, created_at, updated_at
);

-- Badge Users (Pivot)
CREATE TABLE badge_users (
  id, user_id, badge_id, is_active, created_at, updated_at
);

-- Purchases Table
CREATE TABLE purchases (
  id, user_id, amount, description, created_at, updated_at
);
```

## 📋 Comprehensive Project Structure

```

bumpa-app/
├── app/
│ ├── Events/
│ │ ├── AchievementUnlocked.php # Fired when user earns achievement
│ │ ├── BadgeUnlocked.php # Fired when user earns badge
│ │ └── PurchaseMade.php # Fired when user makes purchase
│ │
│ ├── Listeners/
│ │ ├── AwardAchievement.php # Handles PurchaseMade event
│ │ ├── AwardBadge.php # Handles AchievementUnlocked event
│ │ └── AwardBadgeCashbackPayment.php # Handles BadgeUnlocked event
│ │
│ ├── Models/
│ │ ├── User.php # User model with relationships
│ │ ├── Achievement.php # Achievement model
│ │ ├── Badge.php # Badge model
│ │ ├── AchievementUser.php # Pivot model
│ │ ├── BadgeUser.php # Pivot model
│ │ └── Purchase.php # Purchase model
│ │
│ ├── Services/
│ │ ├── AchievementService.php # Achievement business logic
│ │ ├── BadgeService.php # Badge business logic
│ │ └── BadgeCashbackPaymentService.php # Payment processing
│ │
│ ├── Http/
│ │ ├── Controllers/
│ │ │ ├── UserAchievementController.php # API endpoint
│ │ │ └── UserPurchaseController.php # Purchase endpoint
│ │ ├── Middleware/ # HTTP middleware
│ │ └── Requests/ # Form validation requests
│ │
│ └── Providers/
│ └── AppServiceProvider.php # Service provider
│
├── database/
│ ├── migrations/
│ │ ├── 0001_01_01_000000_create_users_table.php
│ │ ├── 2026_04_17_024530_create_achievements_table.php
│ │ ├── 2026_04_17_024543_create_badges_table.php
│ │ ├── 2026_04_17_024843_create_badge_users_table.php
│ │ ├── 2026_04_17_024907_create_achievement_users_table.php
│ │ └── 2026_04_17_030858_create_purchases_table.php
│ │
│ ├── factories/
│ │ └── UserFactory.php # User factory for testing
│ │
│ └── seeders/
│ ├── AchievementsSeeder.php # Seeds achievements
│ ├── BadgesSeeder.php # Seeds badges
│ └── DatabaseSeeder.php # Coordinates seeders
│
├── resources/
│ ├── css/
│ │ └── app.css # Tailwind CSS
│ │
│ ├── js/
│ │ ├── app.tsx # React entry point
│ │ ├── components/
│ │ │ └── ui/ # UI components (Card, Button, etc.)
│ │ ├── layouts/
│ │ │ └── app-layout.tsx # Main layout component
│ │ ├── pages/
│ │ │ ├── dashboard.tsx # Dashboard component
│ │ │ ├── PaymentPage.tsx # Payment/Purchase component
│ │ │ └── welcome.tsx # Welcome page
│ │ └── types/
│ │ └── index.ts # TypeScript type definitions
│ │
│ └── views/ # Blade views (legacy)
│
├── routes/
│ ├── api.php # API routes
│ ├── web.php # Web routes
│ ├── auth.php # Auth routes
│ ├── console.php # Console commands
│ └── settings.php # Settings routes
│
├── config/
│ ├── app.php # App configuration
│ ├── auth.php # Authentication config
│ ├── database.php # Database config
│ ├── mail.php # Mail configuration
│ └── ... # Other configs
│
├── storage/
│ ├── app/ # File storage
│ ├── framework/ # Framework storage
│ └── logs/ # Log files
│
├── tests/
│ ├── Feature/ # Feature tests
│ ├── Unit/ # Unit tests
│ └── TestCase.php # Base test class
│
├── bootstrap/
│ └── app.php # Application bootstrap
│
├── public/
│ ├── index.php # Entry point
│ └── build/ # Built frontend assets (after npm run build)
│
├── .env.example # Environment template
├── .env # Environment configuration (do not commit)
├── composer.json # PHP dependencies
├── package.json # Node.js dependencies
├── vite.config.js # Vite configuration
├── tsconfig.json # TypeScript configuration
├── tailwind.config.js # Tailwind CSS configuration
├── eslint.config.js # ESLint configuration
├── phpunit.xml # PHPUnit configuration
├── artisan # Laravel CLI
└── README.md # This file

```

```

```
