<p align="center">
    <img src="https://raw.githubusercontent.com/filamentphp/filament/3.x/art/logo.svg" alt="Filament Logo" width="400">
</p>

<p align="center">
    <a href="https://filamentphp.com"><img src="https://img.shields.io/badge/Filament-v4.0-orange.svg" alt="Filament v4"></a>
    <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel 12"></a>
    <a href="https://php.net"><img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP 8.2+"></a>
    <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
</p>

# Filament Starter Kit

A modern, production-ready starter kit built with **FilamentPHP v4**, **Laravel 12**, and essential packages for building robust admin panels. This starter comes pre-configured with role-based access control and dynamic menu management.

## ✨ Features

-   🎨 **FilamentPHP v4** - The latest version of the elegant admin panel framework
-   🔐 **Filament Shield** - Complete role and permission management with auto-discovery
-   📋 **Menu Management** - Dynamic navigation builder with role-based visibility
-   🛡️ **Spatie Permission** - Robust role and permission handling
-   ⚡ **Laravel 12** - Latest Laravel framework with modern PHP 8.2+ features
-   🎯 **Production Ready** - Pre-configured and optimized for deployment

## 📦 Included Packages

| Package                                                                         | Version | Description                     |
| ------------------------------------------------------------------------------- | ------- | ------------------------------- |
| [filament/filament](https://filamentphp.com)                                    | ^4.0    | Admin panel framework           |
| [bezhansalleh/filament-shield](https://github.com/bezhanSalleh/filament-shield) | ^4.0    | Role & permission management    |
| [spatie/laravel-permission](https://github.com/spatie/laravel-permission)       | ^6.0    | Backend for roles & permissions |

## 🚀 Installation

### Requirements

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   MySQL / PostgreSQL / SQLite

### Quick Start

1. **Clone the repository**

    ```bash
    git clone https://github.com/your-username/filament-starter.git
    cd filament-starter
    ```

2. **Run Setup Script**

    ```bash
    composer setup
    ```

    This will:

    - Install Composer dependencies
    - Copy `.env.example` to `.env`
    - Generate application key
    - Run database migrations
    - Install NPM dependencies
    - Build assets

3. **Configure your database** in `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=filament_starter
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4. **Setup Filament Shield** (Roles & Permissions):

    ```bash
    php artisan shield:setup
    php artisan shield:generate --all
    php artisan shield:super-admin
    ```

5. **Access the Admin Panel**

    Visit: `http://your-domain/admin`

## 🛠️ Development

Start the development server with all essential services:

```bash
composer dev
```

This command runs concurrently:

-   🌐 Laravel development server
-   📬 Queue listener
-   📝 Laravel Pail (log viewer)
-   ⚡ Vite development server

## 📚 Menu Management

The starter includes a complete **Navigation Management** system that allows you to:

-   ✅ Create multiple navigation menus
-   ✅ Add menu items with labels and URLs
-   ✅ Configure link targets (same tab / new tab)
-   ✅ Set role-based visibility for each menu item
-   ✅ Create nested sub-menus
-   ✅ Reorder items with drag & drop

### Usage Example

```php
use App\Models\Navigation;

// Get navigation by handle
$mainMenu = Navigation::where('handle', 'main-menu')->first();

// Access menu items
foreach ($mainMenu->items as $item) {
    echo $item['label'];
    echo $item['url'];
}
```

## 🔐 Filament Shield

Shield provides automatic permission discovery and generation for all Filament resources:

### Generate Permissions

```bash
# Generate permissions for all resources
php artisan shield:generate --all

# Generate for specific resource
php artisan shield:generate --resource=UserResource
```

### Create Super Admin

```bash
php artisan shield:super-admin
```

## 📁 Project Structure

```
├── app/
│   ├── Filament/
│   │   └── Resources/
│   │       └── NavigationResource.php    # Menu management
│   ├── Models/
│   │   ├── Navigation.php                # Navigation model
│   │   └── User.php                      # User with HasRoles trait
│   ├── Policies/
│   └── Providers/
├── config/
│   ├── filament.php                      # Filament configuration
│   ├── filament-shield.php               # Shield configuration
│   └── permission.php                    # Spatie Permission config
├── database/
│   └── migrations/
│       ├── create_permission_tables.php  # Spatie permissions
│       └── create_navigations_table.php  # Menu management
└── resources/
```

## ⚙️ Configuration

### Filament Shield

Configure Shield settings in `config/filament-shield.php`:

```php
return [
    'super_admin' => [
        'enabled' => true,
        'name' => 'super_admin',
    ],
    // ...
];
```

### Adding New Resources

When you create a new Filament resource, generate its permissions:

```bash
php artisan make:filament-resource Post
php artisan shield:generate --resource=PostResource
```

## 🧪 Testing

Run tests with:

```bash
composer test
```

## 📜 Available Scripts

| Command          | Description               |
| ---------------- | ------------------------- |
| `composer setup` | Complete project setup    |
| `composer dev`   | Start development servers |
| `composer test`  | Run tests                 |

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">
    Made with ❤️ using <a href="https://filamentphp.com">FilamentPHP</a> and <a href="https://laravel.com">Laravel</a>
</p>
