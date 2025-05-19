<?php
include 'connection.php';
header('Content-Type: application/json');

// Get the raw JSON data from the AJAX request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if (isset($data['email'], $data['password'], $data['user_type'])) {
    $email = htmlspecialchars(trim($data['email']));
    $password = htmlspecialchars(trim($data['password']));
    $user_type = htmlspecialchars(trim($data['user_type']));

    // Prepare the SQL query to find the user
    $sql = "SELECT * FROM registration WHERE email = ? AND user_type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $user_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["error" => "Invalid password."]);
        }
    } else {
        echo json_encode(["error" => "User not found. Please register first."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Invalid data received."]);
}
?>