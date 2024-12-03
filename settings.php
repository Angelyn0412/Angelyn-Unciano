<?php
include 'config.php';
// settings.php

// Database configuration
define('DB_SERVER', 'localhost'); // Database server
define('DB_USERNAME', 'root'); // Database username
define('DB_PASSWORD', ''); // Database password (leave empty if no password)
define('DB_NAME', 'job_applications'); // Database name

// Other configuration settings
define('APP_NAME', 'Job Application Tracker'); // Application name
define('APP_VERSION', '1.0.0'); // Application version

// Error reporting (optional, for development)
define('DEBUG_MODE', true); // Set to false in production

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
?>