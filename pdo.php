<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=profiles', 
    'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>