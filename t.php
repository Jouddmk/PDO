<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <form action="t.php" method="POST">
        <label>First Name:</label>
        <input type="text" name="first_name" required><br><br>

        <label>Last Name:</label>
        <input type="text" name="last_name" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Date of Birth:</label>
        <input type="date" name="date_of_birth" required><br><br>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br><br>

        <label>Major:</label>
        <input type="text" name="major"><br><br>

        <label>Enrollment Year:</label>
        <input type="number" name="enrollment_year" min="2022" max="2090" required><br><br>

        <button type="submit">Register Student</button>
    </form>
</body>
</html>

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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $first_name = trim($_POST['first_name']);
      $last_name = trim($_POST['last_name']);
      $email = trim($_POST['email']);
      $date_of_birth = $_POST['date_of_birth'];
      $gender = $_POST['gender'];
      $major = trim($_POST['major']);
      $enrollment_year = $_POST['enrollment_year'];

      
      if (empty($first_name) || empty($last_name) || empty($email) || empty($date_of_birth) || empty($gender) || empty($enrollment_year)) {
          echo "⚠ Please fill in all required fields.";
      } else {
          
        $stmt = $pdo->prepare("INSERT INTO students (first_name, last_name, email, date_of_birth, gender, major, enrollment_year, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$first_name, $last_name, $email, $date_of_birth, $gender, $major, $enrollment_year]);


          echo "✅ Student added successfully!";
      }
  }
    echo "Connected successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>


