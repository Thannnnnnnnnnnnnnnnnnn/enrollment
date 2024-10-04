<?php
session_start(); 

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate a random student ID
    $student_id = uniqid('student_'); 

    // Capture form fields
    $surrname = isset($_POST['surrname']) ? $_POST['surrname'] : '';
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $middlename = isset($_POST['middlename']) ? $_POST['middlename'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $date_of_birth = isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : '';
    $place_of_birth = isset($_POST['place_of_birth']) ? $_POST['place_of_birth'] : '';
    $number = isset($_POST['number']) ? $_POST['number'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $st = isset($_POST['st']) ? $_POST['st'] : '';
    $barangay = isset($_POST['barangay']) ? $_POST['barangay'] : '';
    $district = isset($_POST['district']) ? $_POST['district'] : '';
    $zip = isset($_POST['zip']) ? $_POST['zip'] : '';
    $SHS_school_name = isset($_POST['SHS_school_name']) ? $_POST['SHS_school_name'] : '';
    $strand = isset($_POST['strand']) ? $_POST['strand'] : '';
    $year_graduated = isset($_POST['year_graduated']) ? $_POST['year_graduated'] : '';
    $s_city = isset($_POST['s_city']) ? $_POST['s_city'] : '';
    $s_st = isset($_POST['s_st']) ? $_POST['s_st'] : '';
    $s_barangay = isset($_POST['s_barangay']) ? $_POST['s_barangay'] : '';
    $s_district = isset($_POST['s_district']) ? $_POST['s_district'] : '';
    $s_zip = isset($_POST['s_zip']) ? $_POST['s_zip'] : '';
    $down_payment = isset($_POST['down_payment']) ? $_POST['down_payment'] : '';
    $MOP = isset($_POST['MOD']) ? $_POST['MOD'] : '';

    // Handle file uploads only if files are uploaded
    $TOR = isset($_FILES['TOR']['name']) ? $_FILES['TOR']['name'] : '';
    $diploma = isset($_FILES['diploma']['name']) ? $_FILES['diploma']['name'] : '';
    $good_moral = isset($_FILES['good_moral']['name']) ? $_FILES['good_moral']['name'] : '';
    $picture = isset($_FILES['picture']['name']) ? $_FILES['picture']['name'] : ''; 
    $brgy_indegency = isset($_FILES['brgy_indegency']['name']) ? $_FILES['brgy_indegency']['name'] : ''; 

    // Create the uploads directory if it doesn't exist
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }

    // Move uploaded files only if they are present
    if (!empty($TOR)) {
        move_uploaded_file($_FILES['TOR']['tmp_name'], "uploads/" . $TOR);
    }
    if (!empty($diploma)) {
        move_uploaded_file($_FILES['diploma']['tmp_name'], "uploads/" . $diploma);
    }
    if (!empty($good_moral)) {
        move_uploaded_file($_FILES['good_moral']['tmp_name'], "uploads/" . $good_moral);
    }
    if (!empty($picture)) {
        move_uploaded_file($_FILES['picture']['tmp_name'], "uploads/" . $picture);
    }
    if (!empty($brgy_indegency)) {
        move_uploaded_file($_FILES['brgy_indegency']['tmp_name'], "uploads/" . $brgy_indegency);
    }

    // Insert the data into the database
    $sql_table = "INSERT INTO `enrollment_form` (
        student_id, 
        surrname, 
        firstname, 
        middlename, 
        gender, 
        date_of_birth, 
        place_of_birth, 
        number, 
        email, 
        city, 
        st, 
        barangay, 
        district, 
        zip, 
        SHS_school_name, 
        strand, 
        year_graduated, 
        s_city, 
        s_st, 
        s_barangay, 
        s_district, 
        s_zip,
        TOR,
        diploma,
        good_moral,
        picture,
        brgy_indegency,
        down_payment,
        MOP
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $connections->prepare($sql_table)) {
        $stmt->bind_param("sssssssssssssssssssssssssssss", 
            $student_id, 
            $surrname, 
            $firstname, 
            $middlename, 
            $gender, 
            $date_of_birth, 
            $place_of_birth, 
            $number, 
            $email, 
            $city, 
            $st, 
            $barangay, 
            $district, 
            $zip, 
            $SHS_school_name, 
            $strand, 
            $year_graduated, 
            $s_city, 
            $s_st, 
            $s_barangay, 
            $s_district, 
            $s_zip,
            $TOR,
            $diploma,
            $good_moral,
            $picture,
            $brgy_indegency,
            $down_payment,
            $MOP
        );

        if ($stmt->execute()) {
            // Redirect to the next step after successful submission
            header("Location: next_step_form.php");
            exit(); // Ensure no further code is executed
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
    <title>Enrollment Form</title>
    <link rel="stylesheet" href="E-Form.css">
    <link rel="stylesheet" href="nav.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    <link rel="shortcut icon" href="UP logo.jpeg" type="image/x-icon">
</head>
<body>
<nav>
    <div class="nav-div">
        <h1 class="up-name">Kupal College of the Philippines</h1>
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
    <h1>Enrollment form</h1>
</div>
<br><hr><br>
<div class="main-container">

    <div class="form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <h2>Personal Information</h2>
            <input type="text" placeholder="Surrname" name="surrname" required><br><br>
            <input type="text" placeholder="Firstname" name="firstname" required><br><br>
            <input type="text" placeholder="Middle name" name="middlename" required><br><br>
            <label for="Gender"><b>Gender</b></label><br>
            <select name="gender" id="Gender" required>
                <option value="N/A">Choose</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="">Rather not to say</option>
            </select><br><br>
            <label for="DateOfBirth"><b>Date of Birth</b></label><br>
            <input type="date" name="date_of_birth" required><br><br>
            <input type="text" placeholder="Place of Birth" name="place_of_birth" required><br><br>
            <input type="text" placeholder="Phone Number" name="number" required><br><br>
            <input type="Text" placeholder="Email" name="email" required><br><br>
            <hr>

            <h2>Current Address</h2>
            <input type="text" placeholder="City" name="city"><br><br>
            <input type="text" placeholder="Street No.#" name="st"><br><br>
            <input type="text" placeholder="Barangay" name="barangay"><br><br>
            <input type="text" placeholder="District" name="district"><br><br>
            <input type="text" placeholder="Zip No.#" name="zip"><br><br>
            <hr>
            <h2>Previous School</h2>
            <input type="text" placeholder="Name of School" name="SHS_school_name" required><br><br>
            <label for="Strand"><b>Strand</b></label><br>
            <select name="strand" id="strand" required>
                <option value="N/A">Choose</option>
                <option value="STEM">STEM</option>
                <option value="HUMMS">HUMMS</option>
                <option value="ABM">ABM</option>
                <option value="GAS">GAS</option>
            </select><br><br>
            <label for="YearGraduated"><b>Year Graduated</b></label><br>
            <input type="date" name="year_graduated" required><br><br>
            <hr>
            <h2>School Address</h2>
            <input type="text" placeholder="City" name="s_city"><br><br>
            <input type="text" placeholder="Street No.#" name="s_st"><br><br>
            <input type="text" placeholder="Barangay" name="s_barangay"><br><br>
            <input type="text" placeholder="District" name="s_district"><br><br>
            <input type="text" placeholder="Zip No.#" name="s_zip"><br><br>
            <br>
            <hr>
            <br>
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
            
            <label for="picture">2x2 Picture</label>
            <br>
            <input type="file" name="picture" required>
            <br><br>
            
            <label for="Barangay Indigency">Barangay Indigency</label>
            <br>
            <input type="file" name="brgy_indegency" required>
            <br><br>
            
            <label for="DP">Down Payment</label>
            <br>
            <input type="text" name="down_payment" required placeholder = "Min. 1000 pesos">
            <br><br>
            
            <select name="MOD" id="MOD" required>
                <option value="N/A">Choose</option>
                <option value="Gcash">Gcash</option>
                <option value="MAYA">MAYA</option>
                <option value="Credit card">Credit card</option>
                <option value="Debit card">Debit card</option>
                <option value="VISA">VISA</option>
            </select><br>
            
            <br>
            <center>
                
            <input type="submit" value="submit" class="next-button1">
            </center>
        </form>
    </div>
</div>

<script>
    function showSuccessAlert() {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Form submitted successfully!',
            confirmButtonText: 'Next Step'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'next_step_form.php'; // Redirect to the next step
            }
        });
    }
</script>

</body>
</html>
