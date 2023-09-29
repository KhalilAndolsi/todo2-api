<?php

  include("./config.php");

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    if ($data !== null && isset($data['username']) && isset($data['password'])) {
      $stmt_search = $db->prepare("SELECT * FROM todousers WHERE username = :username");
      $stmt_search->bindParam(':username', $data['username'], PDO::PARAM_STR);

      $stmt_search->execute();
      $user_search = $stmt_search->fetch(PDO::FETCH_ASSOC);


      if ($user_search !== false) {
        http_response_code(404);
        echo json_encode(["msg" => "this username already exists"]);
      } else {
        $username = $data['username'];
        $password = $data['password'];
        try {
          $SQL = "INSERT INTO todousers (username, password, tasks) VALUES (?, ?, ?)";
          $stmt = $db->prepare($SQL);
          $stmt->execute([$username, $password, "{\"tasks\":[]}"]);
  
          $response = [
            "message" => "User created successfully",
            "user_id" => $db->lastInsertId(),
          ];
          http_response_code(200);
          echo json_encode($response);
        } catch (PDOException $e) {
          http_response_code(500);
          echo json_encode(["error" => $e->getMessage()]);
        }
      }
    } else {
      http_response_code(400);
      echo json_encode(["error" => "Invalid input data"]);
    }
  } else {
    http_response_code(405);
    echo json_encode(["error" => "the request method is not POST"]);
  }
