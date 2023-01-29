<?php
$host = '127.0.0.1';
$dbname = 'ssencuesta';
$dbusername = 'anaver';
$dbpassword = '@anaver2023';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}