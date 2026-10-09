<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "students";
$conn = mysqli_connect($host, $user, $pass,$db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";


if (isset($_POST['submit'])) {
    $reg    = trim($_POST['Registration Number'] ?? '');
    $name   = trim($_POST['Name'] ?? '');
    $gender = trim($_POST['Gender'] ?? '');
    $course = trim($_POST['Course'] ?? '');
    $email  = trim($_POST['Email'] ?? '');

    // Validation
    if (empty($reg) || empty($name) || empty($gender) || empty($course) || empty($email)) {
        $message = "<p style='color: red;'>All fields are required!</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<p style='color: red;'>Invalid email address format!</p>";
    } else {
        // Insert into database
        $sql = "INSERT INTO student (Registration Number, Name, Gender, Course, Email) 
                VALUES ('$reg', '$name', '$gender', '$course', '$email')";

        if (mysqli_query($conn, $sql)) {
            $message = "<p style='color: green;'>Student registered successfully!</p>";
        } else {
            $message = "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>University Student Registration</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .form-box { width: 380px; padding: 20px; border: 1px solid #ccc; margin-bottom: 30px; }
        .form-group { margin-bottom: 12px; }
        label { font-weight: bold; display: block; margin-bottom: 4px; }
        input[type="text"], input[type="email"], select { width: 100%; padding: 7px; box-sizing: border-box; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>

    <div class="form-box">
        <h2>Student Registration</h2>
        
        <?= $message; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Registration Number:</label>
                <input type="text" name="reg_number" required>
            </div>

            <div class="form-group">
                <label>Student Name:</label>
                <input type="text" name="student_name" required>
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <input type="radio" name="gender" value="Male" required> Male
                <input type="radio" name="gender" value="Female"> Female
            </div>

            <div class="form-group">
                <label>Course:</label>
                <select name="course" required>
                    <option value="">-- Select Course --</option>
                    <option value="BSc Information Technology">BSc Information Technology</option>
                    <option value="BSc Computer Science">BSc Computer Science</option>
                    <option value="BSc Software Engineering">BSc Software Engineering</option>
                </select>
            </div>

            <div class="form-group">
                <label>Email Address:</label>
                <input type="email" name="email" required>
            </div>

            <input type="submit" name="submit" value="Register Student" style="padding: 8px 15px; cursor: pointer;">
        </form>
    </div>

    <hr>

    <h2>Registered Students List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Reg Number</th>
            <th>Student Name</th>
            <th>Gender</th>
            <th>Course</th>
            <th>Email</th>
        </tr>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['Registration Number']); ?></td>
                <td><?= htmlspecialchars($row['Name']); ?></td>
                <td><?= htmlspecialchars($row['Gender']); ?></td>
                <td><?= htmlspecialchars($row['Course']); ?></td>
                <td><?= htmlspecialchars($row['Email']); ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No student records found.</td></tr>
        <?php endif; ?>
    </table>

</body>
</html>

<?php mysqli_close($conn); ?>