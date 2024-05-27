<?php
session_start();


if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}


$username = $_SESSION['username'];
$user_id = $_SESSION['id'];

include ("db.php");


function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Ensure a category named 'general' exists for this user
$sql_check_general = "SELECT id FROM categories WHERE name = 'general' AND user_id = ?";
$stmt_check_general = $conn->prepare($sql_check_general);
$stmt_check_general->bind_param("i", $user_id);
$stmt_check_general->execute();
$stmt_check_general->store_result();

if ($stmt_check_general->num_rows == 0) {
    // 'general' category does not exist, insert it
    $sql_insert_general = "INSERT INTO categories (name, user_id) VALUES ('general', ?)";
    $stmt_insert_general = $conn->prepare($sql_insert_general);
    $stmt_insert_general->bind_param("i", $user_id);
    $stmt_insert_general->execute();
    $stmt_insert_general->close();
}

$stmt_check_general->close();

$success_message = "";

// Initialize the selected category
$selected_category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : null;

// Check if the add task form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['description'])) {
    // Retrieve form values
    $description = escape($_POST['description']);
    $task_description = escape($_POST['task_description']);
    $category_id = intval($_POST['category_id']);

    $sql = "INSERT INTO tasks (description, task_description, user_id, category_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $description, $task_description, $user_id, $category_id);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        // Update the success message
        $success_message = "Task added succefully.";
    }

    $stmt->close();
}

// Check if the delete task form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_task_id'])) {
    // Retrieve the ID of the task to delete
    $task_id = intval($_POST['delete_task_id']);
    $selected_category_id = intval($_POST['category_id']); // récupérer la catégorie sélectionnée

    $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {

        $success_message = "Task deleted successfully.";
    } else {
        $success_message = "Error when deleting task.";
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complete_task_id'])) {
    $task_id = intval($_POST['complete_task_id']);
    $selected_category_id = intval($_POST['category_id']);

    $sql = "UPDATE tasks SET state = 'completed', completed_at = NOW() WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $success_message = "Tâche terminée avec succès.";
    } else {
        $success_message = "Erreur lors de la terminaison de la tâche.";
    }

    $stmt->close();
}

// Fetch user tasks based on selected category
$sql = "SELECT * FROM tasks WHERE user_id = ? ";
if ($selected_category_id !== null) {
    $sql .= "AND category_id = ? ";
}
$sql .= "ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if ($selected_category_id !== null) {
    $stmt->bind_param("ii", $user_id, $selected_category_id);
} else {
    $stmt->bind_param("i", $user_id);
}
$stmt->execute();
$result = $stmt->get_result();

// Check if the add category form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_category_name'])) {
    $new_category_name = escape($_POST['new_category_name']);
    $sql = "INSERT INTO categories (name, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_category_name, $user_id);
    $stmt->execute();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de To-Do List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="image/1.jpg">

</head>

<body>
    <div class="container">
        <div class="sidebar">
            <h1>todo.</h1>
            <div class="filters">
                <h2>Categories
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button
                        class="add-category" onclick="showAddCategoryForm()"><i class="fas fa-plus"></i></button></h2>
                <form method="POST" action="">
                    <ul>
                        <?php
                        // Fetch categories from the database
                        $sql_categories = "SELECT * FROM categories WHERE user_id = $user_id";
                        $result_categories = $conn->query($sql_categories);
                        if ($result_categories->num_rows > 0) {
                            while ($row_category = $result_categories->fetch_assoc()) {
                                $category_id = $row_category['id'];
                                echo "<li><button class='categorystyle' type='submit' name='category_id' value='$category_id'><i class='fas fa-folder'></i> " . htmlspecialchars($row_category['name']) . "</button></li>";
                            }
                        } else {
                            echo "<li>Aucune catégorie trouvée</li>";
                        }
                        ?>
                    </ul>
                </form>
            </div>
            <div class="projects">
                <h2>Data base</h2>
                <ul>
                    <form action="view_tasks.php" method="get">
                        <button class="add-task" type="submit">Data base</button>
                    </form>
                </ul>
            </div>
            <div class="logout">
                <form action="index.php" method="post">
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Log out</button>
                </form>
            </div>
        </div>
        <div class="space"></div>
        <div class="main-content">
            <div class="tasks">
                <h2>Tasks</h2>
                <ul id="task-list">
                    <?php
                    // PHP code to fetch tasks
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $taskId = $row['id'];
                            $taskTitle = htmlspecialchars($row['description']);
                            $taskDescription = htmlspecialchars($row['task_description']);
                            $createdAt = date('d/m/Y', strtotime($row['created_at']));
                            $completed = $row['state'] === 'completed' ? 'completed' : '';
                            $taskCompletedMessage = '';
                            if ($row['state'] === 'completed') {
                                $completedAt = date('d/m/Y', strtotime($row['completed_at']));
                                $taskCompletedMessage = "<span class='status'>Terminée le $completedAt</span>";
                            }

                            echo "<li class='task-item $completed'>
                                <div class='task-content'>
                                    <strong>$taskTitle</strong><br><br>
                                   
                                    <small>Created: $createdAt</small><br>
                                </div>
                                <div class='actions'>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='delete_task_id' value='$taskId'>
                                        <input type='hidden' name='category_id' value='$selected_category_id'>
                                        <button type='submit' class='delete-button'><i class='fas fa-times'></i></button>
                                    </form>
                                    <button class='desc' onclick='showDescription(\"$taskDescription\")'>
                                        <i class='fas fa-ellipsis-h'></i>
                                    </button>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='complete_task_id' value='$taskId'>
                                        <input type='hidden' name='category_id' value='$selected_category_id'>
                                        <button type='submit' class='complete-button'><i class='fas fa-check'></i></button>
                                    </form>
                                </div>
                                $taskCompletedMessage
                            </li>";
                        }
                    } else {
                        echo "<p>Aucune tâche trouvée pour cette catégorie</p>";
                    }
                    ?>
                </ul>
                <button class="add-task" onclick="showAddTaskForm()">Add Task</button>
            </div>
        </div>
    </div>

    <!-- Add Task Form (hidden by default) -->
    <div class="modal" id="add-task-modal">
        <div class="modal-content">
            <span class="close-button" onclick="hideAddTaskForm()">&times;</span>
            <form id="task-form" method="POST" action="">
                <input type="text" name="description" id="description" placeholder="Task name..." required>
                <textarea name="task_description" id="task_description" placeholder="Task description..."
                    required></textarea>
                <select name="category_id" id="category_id">
                    <?php
                    // Fetch the 'general' category ID
                    $sql_general_category = "SELECT id FROM categories WHERE name = 'general' AND user_id = ?";
                    $stmt_general_category = $conn->prepare($sql_general_category);
                    $stmt_general_category->bind_param("i", $user_id);
                    $stmt_general_category->execute();
                    $stmt_general_category->bind_result($general_category_id);
                    $stmt_general_category->fetch();
                    $stmt_general_category->close();

                    echo "<option value='" . $general_category_id . "'>general</option>";

                    // Fetch other categories from the database for the form
                    $sql_categories = "SELECT * FROM categories WHERE user_id = $user_id AND name != 'general'";
                    $result_categories = $conn->query($sql_categories);
                    if ($result_categories->num_rows > 0) {
                        while ($row_category = $result_categories->fetch_assoc()) {
                            echo "<option value='" . $row_category['id'] . "'>" . htmlspecialchars($row_category['name']) . "</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit">Ajouter une nouvelle tâche</button>
            </form>
        </div>
    </div>

    <!-- Add Category Form (hidden by default) -->
    <div class="modal" id="add-category-modal">
        <div class="modal-content">
            <span class="close-button" onclick="hideAddCategoryForm()">&times;</span>
            <form id="category-form" method="POST" action="">
                <input type="text" name="new_category_name" placeholder="Add category..." required>
                <button type="submit">Ajouter une
                    nouvelle catégorie</button>
            </form>
        </div>
    </div>

    <div class="modal" id="desc-modal">
        <div class="modal-content">
            <span class="close-button" onclick="hideDescription()">&times;</span>
            <div class='task-content'>
                <strong id="task-desc-content"></strong>
            </div>
        </div>
    </div>

    <script>
        function showAddTaskForm() {
            document.getElementById('add-task-modal').style.display = 'block';
        }

        function hideAddTaskForm() {
            document.getElementById('add-task-modal').style.display = 'none';
        }

        function showAddCategoryForm() {
            document.getElementById('add-category-modal').style.display = 'block';
        }

        function hideAddCategoryForm() {
            document.getElementById('add-category-modal').style.display = 'none';
        }

        function showDescription(description) {
            document.getElementById('desc-modal').style.display = 'block';
            document.getElementById('task-desc-content').innerText = description;
        }

        function hideDescription() {
            document.getElementById('desc-modal').style.display = 'none';
        }
    </script>
</body>

</html>

<?php
// Close the prepared statement and connection
$conn->close();
?>