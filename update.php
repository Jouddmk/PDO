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

if (!isset($_GET['id'])) {
    die("Invalid request!");
}

$student_id = $_GET['id'];

// جلب بيانات الطالب المحدد
try {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = ? AND deleted_at IS NULL");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("Student not found!");
    }
} catch (PDOException $e) {
    die("Error fetching student data: " . $e->getMessage());
}

// عند إرسال النموذج يتم تحديث البيانات
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $major = $_POST['major'];
    $enrollment_year = $_POST['enrollment_year'];

    try {
        // تنفيذ استعلام التحديث
        $stmt = $pdo->prepare("UPDATE students 
        SET first_name = ?, last_name = ?, email = ?, date_of_birth = ?, gender = ?, major = ?, enrollment_year = ?, updated_at = NOW() 
        WHERE student_id = ?");
        $stmt->execute([$first_name, $last_name, $email, $date_of_birth, $gender, $major, $enrollment_year, $student_id]);

        // إعادة التوجيه إلى الصفحة الرئيسية بعد التحديث
        header("Location: a.php");
        exit;
    } catch (PDOException $e) {
        die("Error updating student: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Student</title>
</head>
<body>
    <h2>Update Student</h2>
    <form method="POST">
        <label>First Name: <input type="text" name="first_name" value="<?= htmlspecialchars($student['first_name']) ?>" required></label><br>
        <label>Last Name: <input type="text" name="last_name" value="<?= htmlspecialchars($student['last_name']) ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required></label><br>
        <label>Date of Birth: <input type="date" name="date_of_birth" value="<?= htmlspecialchars($student['date_of_birth']) ?>" required></label><br>
        <label>Gender:
            <select name="gender">
                <option value="Male" <?= $student['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $student['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
        </label><br>
        <label>Major: <input type="text" name="major" value="<?= htmlspecialchars($student['major']) ?>" required></label><br>
        <label>Enrollment Year: <input type="number" name="enrollment_year" value="<?= htmlspecialchars($student['enrollment_year']) ?>" required></label><br>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
