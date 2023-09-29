<?php
  include("./config.php");

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    if ($data !== null && isset($data['username']) && isset($data['password'])) {
      $sql = $db->prepare("SELECT * FROM todousers WHERE username = :username AND password = :password");
      $sql->bindParam(':username', $data['username'], PDO::PARAM_STR);
      $sql->bindParam(':password', $data['password'], PDO::PARAM_STR);
      $sql->execute();
      $user_data = $sql->fetch(PDO::FETCH_ASSOC);
      if ($user_data !== false) {
        $user_data["tasks"] = json_decode($user_data["tasks"]);
        http_response_code(200);
        echo json_encode($user_data);
      } else {
        http_response_code(401);
        echo json_encode(["error" => "Verify the username or the password please"]);
      }
    }
  } else {
    http_response_code(405);
    echo json_encode(["error" => "the request method is not POST"]);
  }
