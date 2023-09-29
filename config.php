<?php
  header("Access-Control-Allow-Origin: *"); 
  header("Access-Control-Allow-Methods: *"); 
  header("Access-Control-Allow-Headers: Content-Type"); 
  header('Content-Type: application/json'); 

  $db_host = 'fdb1033.awardspace.net';
  $db_user = '4373693_mydb';    
  $db_password = 'FCDdAWqr5!+epCU';   
  $db_name = '4373693_mydb';  

  try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // Set default fetch mode to objects
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Disable emulated prepared statements
  } catch(PDOException $e) {
    die($e->getMessage());
  };
