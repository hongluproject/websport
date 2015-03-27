<?php

// Start database connection
$db = new \Core\Database(config('database.default'));

// Connect to databse server
$db->connect();

// Set name of migration object
$migration = '\Core\Migration\\' . ucfirst($db->type);

// Create migration object
$migration = new $migration;

// Set database connection
$migration->db = $db;

// Set the database name
$migration->name = 'default';

// Load table configuration
$migration->tables = include(SP . 'config/migration.php');

// Backup existing database table
$migration->backup_data();
$migration->create_schema();
$migration->restore_data();
