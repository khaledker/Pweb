<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $task_id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

    if ($task_id) {
        $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ii", $task_id, $_SESSION['id']);
            if ($stmt->execute()) {
                header("Location: task.php");
                exit;
            } else {
                echo "Error when deleting the task.";
            }

            $stmt->close();
        } else {
            echo "// Error preparing the query.";
        }
    } else {
        echo "Invalid ID task";
    }
}

$conn->close();
?>