# MomiPro - WooCommerce Marketplace MVP

This project contains the scaffolding and initial code for the MomiPro marketplace, a multi-vendor WooCommerce platform.

## 1. Project Structure

```
MomiPro/
├── docker-compose.yml
├── .htaccess
├── wp-config.php
├── wp-admin/
├── wp-content/
│   ├── mu-plugins/
│   │   └── momipro-customizations/
│   │       └── momipro-customizations.php  # For custom code (e.g., KYC fields)
│   ├── plugins/
│   │   ├── woocommerce/
│   │   ├── dokan-pro/
│   │   └── cedcommerce-amazon-connector/
│   └── themes/
│       └── momipro-theme/                  # Custom theme
│           ├── style.css
│           ├── index.php
│           ├── header.php
│           ├── footer.php
│           ├── functions.php
│           └── front-page.php
└── wp-includes/
```

## 2. Local Development Setup (Docker)

This project includes a Docker setup for a consistent local development environment.

### Prerequisites

- [Docker](https://www.docker.com/get-started) installed on your machine.

### Steps

1.  **Clone the repository** (or use the generated files).
2.  **Navigate to the project root** (`MomiPro/`).
3.  **Start the services:**
    ```bash
    docker-compose up -d
    ```
4.  **Access WordPress:**
    -   URL: `http://localhost:8000`
    -   Admin: `http://localhost:8000/wp-admin`
    -   Username: `admin`
    -   Password: `password`
5.  **Access phpMyAdmin:**
    -   URL: `http://localhost:8080`
    -   Server: `mysql`
    -   Username: `root`
    -   Password: `password`

## 3. Manual Setup & Configuration (Without Docker)

### Prerequisites

- A web server (Apache, Nginx) with PHP and MySQL/MariaDB.
- [WordPress](https://wordpress.org/download/) latest version.

### Steps

1.  **Download WordPress:** Download the latest version of WordPress and place the contents in your web server's root directory.
2.  **Database Setup:** Create a MySQL database and a user with privileges for that database.
3.  **Configure `wp-config.php`:**
    -   Rename `wp-config-sample.php` to `wp-config.php`.
    -   Update the following values with your database credentials:
        ```php
        define( 'DB_NAME', 'your_database_name' );
        define( 'DB_USER', 'your_database_user' );
        define( 'DB_PASSWORD', 'your_database_password' );
        define( 'DB_HOST', 'localhost' );
        ```
4.  **WordPress Installation:** Access your site's URL and follow the on-screen instructions to complete the WordPress installation.

## 4. Plugin Installation & Configuration

You will need to manually install and configure the required plugins.

### Required Plugins:

-   **WooCommerce:** The core e-commerce engine.
-   **Dokan Pro:** For multi-vendor functionality. You will need a valid license.
-   **CedCommerce Amazon Connector:** To sync with Amazon. You may need a license.

### Installation:

1.  **Download the plugins:**
    -   WooCommerce: Can be installed from the WordPress plugin directory.
    -   Dokan Pro & Amazon Connector: Download the zip files from their respective websites.
2.  **Upload and activate:**
    -   In the WordPress admin, go to `Plugins > Add New > Upload Plugin`.
    -   Upload the zip files and activate the plugins.
3.  **Run Setup Wizards:** Both WooCommerce and Dokan have setup wizards that will guide you through the basic configuration.

## 5. Theme Activation

1.  In the WordPress admin, go to `Appearance > Themes`.
2.  Activate the **MomiPro Theme**.

## 6. Amazon Connector Configuration

1.  Follow the documentation provided by CedCommerce to connect your Amazon Seller Central account.
2.  Configure the synchronization settings for products, inventory, and orders.

## 7. Launching Your MVP

### 1. Hosting

-   Choose a managed WordPress host like [Cloudways](https://www.cloudways.com/), [Kinsta](https://kinsta.com/), or a VPS provider like [DigitalOcean](https://www.digitalocean.com/).
-   Follow their instructions to set up a new WordPress site.

### 2. SSL Certificate

-   Most managed hosts provide a free SSL certificate (Let's Encrypt).
-   Ensure that your site is running on `https://`.

### 3. Deployment

1.  **Migrate your local site:** Use a migration plugin like [All-in-One WP Migration](https://wordpress.org/plugins/all-in-one-wp-migration/) to move your local site to the live server.
2.  **Configure DNS:** Point your domain (`momipro.com`) to your web host's IP address.
3.  **Final Testing:**
    -   Test the vendor registration process.
    -   Test product creation and management.
    -   Place a test order to ensure the checkout process works correctly.
    -   Verify that vendor commissions are calculated correctly.

## 8. Security & Performance

-   **Security:**
    -   Use strong passwords for all accounts.
    -   Install a security plugin like [Wordfence](https://wordpress.org/plugins/wordfence/).
    -   Keep WordPress, themes, and plugins updated.
-   **Performance:**
    -   Install a caching plugin like [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/).
    -   Optimize images before uploading.
    -   Use a Content Delivery Network (CDN).
