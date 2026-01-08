<?php
$host = "localhost";
$dbname = "megacars";
$username = "root"; 
$password = "Super";

try {
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
echo "Erreur : " . $e->getMessage();
}


//testestest