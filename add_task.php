<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
include 'db.php';

$user_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $description = htmlspecialchars($_POST['description']);
    $sql = "INSERT INTO tasks (description, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $description, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Task added successfully.";
    } else {
        echo "Error adding task: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>