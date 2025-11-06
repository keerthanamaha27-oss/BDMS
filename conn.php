<?php
// PostgreSQL credentials from Render
$host = getenv('DB_HOST') ?: 'dpg-d46bfradbo4c738dh4q0-a.singapore-postgres.render.com';
$db   = getenv('DB_NAME') ?: 'bdms_db';
$user = getenv('DB_USER') ?: 'bdms_user';
$pass = getenv('DB_PASS') ?: 'a3sl10eRk8wzjpviS2pM4ae4UTgxT0pv';

// Connect to PostgreSQL
$conn_string = "host=$host dbname=$db user=$user password=$pass";
$conn = pg_connect($conn_string);

// Check connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>

