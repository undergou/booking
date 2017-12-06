<?php
$pdo = new PDO("mysql:host=localhost;dbname=booking", "root", "");
$adminEmail = 'admin@bookingmodule.com';
if(defined('SITE_ADMIN')) die('<div class="alert alert-danger"><h1>Page not found</h1></div>');
?>
