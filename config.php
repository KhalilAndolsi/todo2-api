<?php
  header("Access-Control-Allow-Origin: *"); 
  header("Access-Control-Allow-Methods: *"); 
  header("Access-Control-Allow-Headers: Content-Type"); 
  header('Content-Type: application/json'); 

  $db_host = 'ep-calm-thunder-96135345-pooler.us-east-1.postgres.vercel-storage.com';
  $db_user = 'default';    
  $db_password = '9cZC5PnSkIWX';   
  $db_name = 'verceldb';  

  try {
    $db = new PDO("pgsql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // Set default fetch mode to objects
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Disable emulated prepared statements
  } catch(PDOException $e) {
    die($e->getMessage());
  };
