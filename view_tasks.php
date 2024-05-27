<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_bdd.css">
    <link rel="icon" href="image/1.jpg">

    <title>Data base</title>
</head>

<body>
    <h2>Data base</h2>

    <?php
    include 'db.php';

    // Ensure connection is established
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT tasks.*, users.username 
            FROM tasks 
            INNER JOIN users ON tasks.user_id = users.id
            ORDER BY tasks.created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>username</th>
                    <th>Description de la tâche</th>
                    <th>Category</th>
                    <th>État</th>
                    <th>Date de création</th>
                    <th>Date de fin</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            $taskId = $row['id'];
            $username = htmlspecialchars($row['username']);
            $taskDescription = htmlspecialchars($row['description']);
            $taskState = htmlspecialchars($row['state']);
            $createdAt = date('d/m/Y H:i', strtotime($row['created_at']));
            $cat = htmlspecialchars($row['category_id']);
            $completedAt = isset($row['completed_at']) ? date('d/m/Y H:i', strtotime($row['completed_at'])) : '-';
            echo "<tr>
                    <td>$taskId</td>
                    <td>$username</td>
                    <td>$taskDescription</td>
                    <td>$cat</td>
                    <td>$taskState</td>
                    <td>$createdAt</td>
                    <td>$completedAt</td>
                </tr>";
            echo "<tr>
            </tr>";


        }
        echo "</table>";
    } else {
        echo "<p>No task found.</p>";
    }

    // Close the connection
    $conn->close();
    ?>

    <div class="btn-centered">
        <a href="task.php" class="btn-retour">Retour</a>
    </div>


</body>

</html>