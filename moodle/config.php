<?php
unset($CFG);
global $CFG;
$CFG = new stdClass();

// --- Base de datos (credenciales desde variables de entorno) ---
$CFG->dbtype    = 'mariadb';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'moodle-db';
$CFG->dbname    = getenv('MOODLE_DB_NAME');
$CFG->dbuser    = getenv('MOODLE_DB_USER');
$CFG->dbpass    = getenv('MOODLE_DB_PASSWORD');
$CFG->prefix    = 'mdl_';
$CFG->dboptions = [
    'dbpersist'   => 0,
    'dbport'      => 3306,
    'dbsocket'    => '',
    'dbcollation' => 'utf8mb4_unicode_ci',
];

// --- URL dinámica: funciona por Tailscale, IP local o nombre ---
$host = $_SERVER['HTTP_HOST'] ?? getenv('MOODLE_HOST');
$CFG->wwwroot  = 'http://' . $host;

// --- Rutas ---
$CFG->dataroot = '/var/moodledata';
$CFG->admin    = 'admin';
$CFG->directorypermissions = 02777;

require_once(__DIR__ . '/lib/setup.php'); // Do not edit
