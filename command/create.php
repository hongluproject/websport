<?php

// Start database connection
$db = new \Core\Database(config('database.default'));

// Connect to databse server
$db->connect();

// Set name of migration object
$migration = '\Core\Migration\\' . ($db->type == 'mysql' ? 'MySQL' : 'PGSQL');

// Create migration object
$migration = new $migration;

// Set database connection
$migration->db = $db;

// Set the database name
$migration->name = 'default';

// Load table configuration
$migration->tables = (array)config('migration');

// Backup existing database table
$migration->create_schema();
