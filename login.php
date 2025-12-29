<?php
session_start();
require_once "pdo.php";

if (isset($_POST['email']) && isset($_POST['pass'])) {
    // PHP validation
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
    }
    
    if (!strpos($_POST['email'], '@')) {
        $_SESSION['error'] = "Email must contain @";
        header("Location: login.php");
        return;
    }
    
    $salt = 'XyZzy12*_';
    $check = hash('md5', $salt.$_POST['pass']);
    
    $stmt = $pdo->prepare('SELECT user_id, name FROM users 
        WHERE email = :em AND password = :pw');
    $stmt->execute(array(
        ':em' => $_POST['email'],
        ':pw' => $check
    ));
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row !== false) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['success'] = "Login successful";
        header("Location: index.php");
        return;
    } else {
        $_SESSION['error'] = "Incorrect email or password";
        header("Location: login.php");
        return;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>John Doe's Login Page</title>
    <script>
    function doValidate() {
        console.log('Validating...');
        try {
            email = document.getElementById('email').value;
            pw = document.getElementById('id_1723').value;
            console.log("Validating email=" + email);
            
            if (email == null || email == "" || pw == null || pw == "") {
                alert("Both fields must be filled out");
                return false;
            }
            
            if (email.indexOf('@') == -1) {
                alert("Invalid email address");
                return false;
            }
            
            return true;
        } catch(e) {
            return false;
        }
        return false;
    }
    </script>
</head>
<body>
<div class="container">
    <h1>Please Log In</h1>
    
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    ?>
    
    <form method="POST" action="login.php">
        <p>Email: <input type="text" name="email" id="email"></p>
        <p>Password: <input type="password" name="pass" id="id_1723"></p>
        <input type="submit" onclick="return doValidate();" value="Log In">
        <input type="button" value="Cancel" onclick="location.href='index.php';">
    </form>
    
    <p>For a password hint, view source and find an account and password in the HTML comments.</p>
    <!-- Hint: The account is umsi@umich.edu, password is php123 -->
</div>
</body>
</html>