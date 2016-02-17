<?php
$host = 'localhost';
// mysql hostname
$hostname = 'localhost';
// mysql username
$username = 'clubhouse';
$database = 'clubhouse';
// mysql password
$password = 'clubhouse';
// Database Connection using PDO with Try Catch Statements
try {
$dbh = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
?>
