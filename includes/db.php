<?php

session_start();

$host = 'localhost';
$db   = 'ifoa_user';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $user, $pass, $options);


$user_db = false;

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id;");

    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
    ]);

    $user_db = $stmt->fetch();
};
