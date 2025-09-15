# Shopify Product Sync - Laravel + Vue.js Demo

## Description

This is a full-stack web application demonstrating product synchronization between Shopify and a Laravel backend with Vue.js frontend. The application features a RESTful API built with Laravel that handles product data management, while the frontend uses Vue.js to provide a reactive dashboard for viewing and syncing products. The system includes mock Shopify data for demonstration purposes, showcasing modern web development practices with proper separation of concerns between backend API and frontend SPA components. The interface displays product cards with real-time updates, inventory tracking, and synchronization status. Built with Laravel 12, Vue.js 3, and MySQL database integration.

## Quick Setup Tutorial

### Prerequisites

-   Docker with Laradock installed or Laravel Sail
-   Node.js and npm
-   PHP and Composer

### Installation Steps

** ENV Setup **

`````
cp .env.example .env
# Setup all neded variables
php artisan key:generate
`````

** Database **

**bash**
`php artisan migrate`

**Install Frontend Dependencies**

**bash**
`npm install vue@^3.3.0 @vitejs/plugin-vue axios`

**Setup API Routes**

-   Add API routes in routes/api.php
-   Create controllers: php artisan make:controller ProductController
-   Create models: php artisan make:model Product -m

**Build Assets**

**bash**

````
npm run build
php artisan cache:clear`
````

1.  **Configure Nginx**

    -   Add site configuration for your domain
    -   Remove CSP headers if present
    -   Restart nginx: docker-compose restart nginx

2.  **Access Application**

    -   Visit https://your-domain.local/
    -   Click "Sync Products" to load demo data
    -   View synchronized products in the dashboard

### Key Files

-   routes/api.php - API endpoints
-   app/Http/Controllers/ - Backend controllers
-   resources/js/components/ProductSync.vue - Main Vue component
-   resources/views/dashboard.blade.php - Main template
-   vite.config.js - Frontend build configuration
