<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
include 'db.php';

$user_id = $_SESSION['id'];

if (isset($_POST['id'])) {
    $taskId = $_POST['id'];
    $sql = "UPDATE tasks SET state = 'completed', completed_at = NOW() WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $taskId, $user_id);
    $stmt->execute();

    header("Location: task.php");
    exit;
}
?>