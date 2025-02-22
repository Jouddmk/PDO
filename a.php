
<?php
$dsn = "mysql:host=localhost;dbname=task;charset=utf8mb4";
$username = "root";
$password = "";
try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES => false, 
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<?php
try {
    $stmt = $pdo->query("SELECT student_id, first_name, last_name, email, date_of_birth, gender, major, enrollment_year, 
                         created_at, updated_at, 
                         CASE WHEN deleted_at IS NULL THEN 'Active' ELSE 'Deleted' END AS status 
                         FROM students");
    // $stmt = $pdo->query("SELECT student_id, first_name,  last_name, email, date_of_birth, gender, major, enrollment_year,created_at, updated_at 
    //   IFNULL(deleted_at, 'Active') AS status FROM students ");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <style>
        table {
            width: 120%;
            border-collapse: collapse;
            margin: 20px 0;
            padding: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .action-links a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            color: white;
        }
        .update-btn { background-color: blue; }
        .delete-btn { background-color: red; }
    </style>
</head>
<body>

<h2>Student List</h2>

<table>
    <thead>
        <tr>
            <th>student_id</th>
            <th>first_name</th>
            <th>last_name</th>
            <th>email</th>
            <th>date_of_birth</th>
            <th>gender</th>
            <th>major</th>
            <th>enrollment_year</th>
            <th>Status</th>
            <th>Actions</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['student_id']) ?></td>
                <td><?= htmlspecialchars($student['first_name']) ?></td>
                <td><?= htmlspecialchars($student['last_name']) ?></td>
                <td><?= htmlspecialchars($student['email']) ?></td>
                <td><?= htmlspecialchars($student['date_of_birth']) ?></td>
                <td><?= htmlspecialchars($student['gender']) ?></td>
                <td><?= htmlspecialchars($student['major']) ?></td>
                <td><?= htmlspecialchars($student['enrollment_year']) ?></td>
                <td><?= htmlspecialchars($student['status']) ?></td>
                <td><?= htmlspecialchars($student['created_at']) ?></td>
                <td><?= htmlspecialchars($student['updated_at']) ?></td>
                <td class="action-links">
                
                    <a href="update.php?id=<?= $student['student_id'] ?>" class="update-btn">Update</a>
                    <a href="s.php?id=<?= $student['student_id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
