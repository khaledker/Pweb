<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo_list_db";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$db_create = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($db_create) === TRUE) {
} else {
    echo "Error creating database: " . $conn->error;
}


$conn->select_db($dbname);

// Creation of the 'users' table
$req_2 = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$res_2 = mysqli_query($conn, $req_2);

// Creation of the 'categories' table

$cat = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";
$req = mysqli_query($conn, $cat);

// Creation of the 'tasks' table

$req = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    task_description VARCHAR(255) NOT NULL,
    state ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id) 

)";
$res = mysqli_query($conn, $req);
if ($res && $res_2 && $req) {
} else {
    echo "Error creating tables: " . $conn->error;
}


?>