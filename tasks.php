<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_manager";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_task'])) {
        $task = $_POST['task'];
        $sql = "INSERT INTO tasks (task) VALUES ('$task')";
        if ($conn->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete_task'])) {
        $task_id = $_POST['task_id'];
        $sql = "DELETE FROM tasks WHERE id=$task_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$sql = "SELECT id, task FROM tasks";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
</head>
<body>
    <h1>Task Manager</h1>

    <form method="POST" action="">
        <input type="text" name="task" required>
        <button type="submit" name="add_task">Dodaj Zadanie</button>
    </form>

    <h2>Task List</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li>" . $row["task"] . " <form method='POST' action='' style='display:inline;'>
                    <input type='hidden' name='task_id' value='" . $row["id"] . "'>
                    <button type='submit' name='delete_task'>Usuń</button>
                    </form></li>";
            }
        } else {
            echo "Nie znaleziono zadań";
        }
        ?>
    </ul>
</body>
</html>
