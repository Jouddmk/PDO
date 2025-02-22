<?php
// require 'db_connection.php';
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

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    
    // echo "Trying to delete student with ID: " . htmlspecialchars($student_id) . "<br>"; // للتحقق من وصول ID

    try {
        $stmt = $pdo->prepare("UPDATE students SET deleted_at = NOW() WHERE student_id = ?");
        $stmt->execute([$student_id]);

        // echo "Student deleted successfully!";
        header("Location: a.php");
        exit;
    } catch (PDOException $e) {
        die("Error deleting student: " . $e->getMessage());
    }
}
?>