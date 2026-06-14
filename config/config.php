<?php
// ============================================================
// COSMEET — Configuration
// ============================================================

define('APP_NAME',    'Cosmeet');
define('APP_URL', 'http://localhost/cosmeet/public');
define('APP_VERSION', '1.0.0');

// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'cosmeet');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Security
define('SECRET_KEY', 'cosmeet_secret_2026_change_in_production');
define('BCRYPT_COST', 12);
define('SESSION_NAME', 'cosmeet_session');
define('CSRF_TOKEN_NAME', '_csrf_token');

// Paths
define('ROOT_PATH',   dirname(__DIR__));
define('SRC_PATH',    ROOT_PATH . '/src');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('VIEW_PATH',   SRC_PATH . '/Views');

// Uploads
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB

// Pagination
define('PER_PAGE', 12);

// Email (configure for production)
define('MAIL_HOST', 'smtp.mailtrap.io');
define('MAIL_PORT', 587);
define('MAIL_USER', '');
define('MAIL_PASS', '');
define('MAIL_FROM', 'no-reply@cosmeet.space');
define('MAIL_FROM_NAME', 'Cosmeet Mission Control');
