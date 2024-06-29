<?php

$db_name = 'mysql:host=localhost;port=3307;dbname=bookshop';
$user_name = 'root';
$user_password = '';
$options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]; 

$conn = new PDO($db_name, $user_name, $user_password, $options);

?>
