<?php
    const USER = '[USERNAME]';
    const PASSWORD = '[PASSWORD]';
    const HOST = '[HOST]';
    const DATABASE = '[SCHEMA]';
    try {
        $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
    } catch (PDOException $e) {
        exit("There was a problem connecting to the servers. Please try again later.");
    }
?>
