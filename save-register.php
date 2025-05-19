<?php
 include 'connection.php';
 header('Content-Type: application/json');

// Get the raw JSON data from the AJAX request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Check if data is valid
if (isset($data['first_name'], $data['email'], $data['password'], $data['phone_no'])) {
    $first_name = htmlspecialchars(trim($data['first_name']));
    $last_name = htmlspecialchars(trim($data['last_name']));
    $address = htmlspecialchars(trim($data['address']));
    $phone_no = htmlspecialchars(trim($data['phone_no']));
    $email = htmlspecialchars(trim($data['email']));
    $user_type = htmlspecialchars(trim($data['user_type']));
    $password = password_hash($data['password'], PASSWORD_DEFAULT);    //decrypt

    // Prepare the SQL query
    $sql = "INSERT INTO registration (first_name, last_name, address, phone_no, email, user_type, password)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $first_name, $last_name, $address, $phone_no, $email, $user_type, $password);

    if ($stmt->execute()) {
        echo json_encode(["success" => " Registration successful!"]);
    } else {
        echo json_encode(["error" => "Error: Could not save data."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => " Invalid data received."]);
}
?>
