<?php

use Twilio\Rest\Client;

$Email = $password = "";
$EmailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Email"])) {
        $EmailErr = "Email is Required";
    } else {
        $Email = $_POST["Email"];
    }
    if (empty($_POST["password"])) {
        $passwordErr = "Password is Required";
    } else {
        $password = $_POST["password"];
    }
    if ($Email && $password) {
        include("connections.php");
        $check_email = mysqli_query($connections, "SELECT Email, password, Account_type, Contact_No FROM accounts WHERE Email = '$Email'");
        $check_email_row = mysqli_num_rows($check_email);
        if ($check_email_row > 0) {
            while ($row = mysqli_fetch_assoc($check_email)) {
                $db_password = $row["password"];
                $db_account_type = $row["Account_type"];
                $contact_no = $row["Contact_No"];
                if ($db_password == $password) {
                    
                  

                   
                    if ($db_account_type == "1") {
                        header("Location: Dashboard"); 
                        exit();
                    } else {
                        header("Location: add_vehicle"); 
                        exit();
                    }
                }
            }
        } else {
            echo "Invalid email or password.";
        }
    }
}



?>

<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="shortcut icon" href="Cross-Logo.png" type="image/x-icon">
</head>
<body>
    
<div class="wave"></div>
    <div class="wave"></div>
    <div class="wave"></div>
    
    <div class="login-container">
        <h1><center>Enrollment management login</h1></center>
        
      
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-login">
                <label for="Email">Email:</label>
                <input type="email" id="Email" name="Email" value="<?php echo $Email;?>">
                <span class="error"><?php echo $EmailErr; ?></span>
            </div>
            <div class="form-login">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $password; ?>">
                <span class="error"><?php echo $passwordErr; ?></span>
            </div>
            <br>
            <input type="submit" class="back-to-home-button" value="Login">
        </form>
        <br>
        <div class="additional-options">
            <p>Don't have an account? <a href="signup">Sign up</a></p>
        </div>
        <img class="logo2" src="logoto.png" alt="" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 600px; height: 600px; margin-left: 50%; transform: translate(-50%, -50%); max-width: 600px; height: 600px; margin-left: 900px;">
    </div>
    <br>
    <br>
    <footer style="margin-left: px;">
        <p>©Enrollment Mangement.All rights reserved</p>
        <p> BSIT - 3106 - IM</p> 
    </footer>
</body>
</html>
