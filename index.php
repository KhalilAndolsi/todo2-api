<?php 
  include("./config.php");

  if ($_SERVER['REQUEST_METHOD'] === "GET") {
      try {
          $SQL = "SELECT * FROM todousers";
          $stmt = $db->query($SQL);
          $users_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
          foreach ($users_data as &$user) {
              $user['tasks'] = json_decode($user['tasks'], true);
          }
          http_response_code(200);
          echo json_encode($users_data);
      } catch (PDOException $e) {
          http_response_code(500);
          echo json_encode(["error" => $e->getMessage()]);
      }
  } else {
    http_response_code(405);
    echo json_encode(["error" => "the request method is not GET"]);
  }

