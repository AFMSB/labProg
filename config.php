<?php
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'homestead');
define('DB_PASSWORD', 'secret');
define('DB_NAME', 'projeto');

$pdo = null;

try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}