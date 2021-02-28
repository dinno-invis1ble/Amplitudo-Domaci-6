<?php 

    $dsn = "mysql:host=localhost";
    $user = "root";
    $pass = "";

    $pdo = new PDO($dsn, $user, $pass);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->query("CREATE DATABASE IF NOT EXISTS immovables_db");
    $pdo->query("use immovables_db");   

?>