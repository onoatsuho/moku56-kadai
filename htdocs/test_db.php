<?php
try {
    $db = new PDO("mysql:host=mysql;dbname=wiki_db;charset=utf8mb4", "wiki_user", "wiki_pass");
    echo "OK";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}