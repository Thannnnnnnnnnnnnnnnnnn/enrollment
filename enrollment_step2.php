<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve session data and additional fields
    $student_id = $_SESSION['student_id']; // Ensure this is set properly

    // Use file names for storage paths
    $TOR = $_FILES['TOR']['name'];
    $diploma = $_FILES['diploma']['name'];
    $good_moral = $_FILES['good_moral']['name'];
    $two_x_two_picture = $_FILES['2x2_picture']['name'];
    $brgy_indegency = $_FILES['brgy_indegency']['name'];
    $down_payment = isset($_POST['down_payment']) ? $_POST['down_payment'] : '';
    $MOP = isset($_POST['MOD']) ? $_POST['MOD'] : ''; // Ensure the field name matches

    // Create the uploads directory if it doesn't exist
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }

    // Handle file uploads - move files to the "uploads" directory
    move_uploaded_file($_FILES['TOR']['tmp_name'], "uploads/" . $TOR);
    move_uploaded_file($_FILES['diploma']['tmp_name'], "uploads/" . $diploma);
    move_uploaded_file($_FILES['good_moral']['tmp_name'], "uploads/" . $good_moral);
    move_uploaded_file($_FILES['2x2_picture']['tmp_name'], "uploads/" . $two_x_two_picture);
    move_uploaded_file($_FILES['brgy_indegency']['tmp_name'], "uploads/" . $brgy_indegency);

    // Prepare your database query
    $sql_table = "UPDATE `enrollment_form` SET 
        TOR = ?, 
        diploma = ?, 
        good_moral = ?, 
        `2x2_picture` = ?, 
        brgy_indegency = ?, 
        down_payment = ?, 
        MOP = ? 
        WHERE student_id = ?";

    if ($stmt = $connections->prepare($sql_table)) {
        $stmt->bind_param("ssssssss", $TOR, $diploma, $good_moral, $two_x_two_picture, $brgy_indegency, $down_payment, $MOP, $student_id);

        if ($stmt->execute()) {
            echo "<script>showSuccessAlert();</script>";
        } else {
            echo "Error executing statement: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $connections->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="e-Form.css">
    <link rel="stylesheet" href="nav.css">
    <title>Enrollment Step 2</title>
</head>
<body>
<nav>
    <div class="nav-div">
        <h1 class="up-name">Lei College of the Philippines</h1>
    </div>
    <div class="nav-links">
        <a href="#" class="links">History |</a>
        <a href="#" class="links">Admission |</a>
        <a href="#" class="links">Login |</a>
        <a href="#" class="links">Alumni</a>
    </div>
</nav>
<br>
<div class="admission">
    <h1>Enrollment Form</h1>
</div>
<br><hr><br>
<div class="main-container">
    <div class="form">
        <h1>Additional Documents</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="TOR">Transcript of Records (TOR)</label>
            <br>
            <input type="file" name="TOR" required>
            <br><br>
            
            <label for="Diploma">Diploma</label>
            <br>
            <input type="file" name="diploma" required>
            <br><br>
            
            <label for="Good Moral">Good Moral</label>
            <br>
            <input type="file" name="good_moral" required>
            <br><br>
            
            <label for="2x2">2x2 Picture</label>
            <br>
            <input type="file" name="2x2_picture" required>
            <br><br>
            
            <label for="Barangay Indigency">Barangay Indigency</label>
            <br>
            <input type="file" name="brgy_indegency" required>
            <br><br>
            
            <label for="DP">Down Payment</label>
            <br>
            <input type="text" name="down_payment" required>
            <br><br>
            
            <select name="MOD" id="MOD" required>
                <option value="N/A">Choose</option>
                <option value="Gcash">Gcash</option>
                <option value="MAYA">MAYA</option>
                <option value="Credit card">Credit card</option>
                <option value="Debit card">Debit card</option>
                <option value="VISA">VISA</option>
            </select><br>
            
            <input type="submit" value="Submit" class="next_button1">
        </form>
    </div>
</div>
</body>
</html>
