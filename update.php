<?php 
  include("./config.php");
  
  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data);
    if ($data !== null && isset($data->username) && isset($data->password) && isset($data->tasks)) {
      $data->tasks = json_encode($data->tasks);
      $sql = "UPDATE todousers SET tasks = :tasks WHERE username = :username AND password = :password";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':username', $data->username);
      $stmt->bindParam(':password', $data->password);
      $stmt->bindParam(':tasks', $data->tasks);
      if ($stmt->execute()) {
        $stmt_search = $db->prepare("SELECT * FROM todousers WHERE username = :username");
        $stmt_search->bindParam(':username', $data->username, PDO::PARAM_STR);
        $stmt_search->execute();
        $user_search = $stmt_search->fetch(PDO::FETCH_ASSOC);
        if ($user_search !== false) {
          http_response_code(200);
          echo json_encode(array('success' => 'Update is successful'));
        } else {
          http_response_code(401);
          echo json_encode(array('error' => 'Verify the username or the password please'));
        }
      } else {
          http_response_code(500);
          echo json_encode(array('error' => 'Update failed'));
      }
    }
  }else {
    http_response_code(405);
    echo json_encode(["error" => "the request method is not PUT"]);
  }
