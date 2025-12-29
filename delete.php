<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['name'])) {
    die("Not logged in");
}

if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing profile_id";
    header("Location: index.php");
    return;
}

// Check if profile exists and belongs to user
$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :pid AND user_id = :uid");
$stmt->execute(array(
    ':pid' => $_GET['profile_id'],
    ':uid' => $_SESSION['user_id']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row === false) {
    $_SESSION['error'] = "Could not load profile";
    header("Location: index.php");
    return;
}

if (isset($_POST['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM Profile WHERE profile_id = :pid AND user_id = :uid');
    $stmt->execute(array(
        ':pid' => $_POST['profile_id'],
        ':uid' => $_SESSION['user_id']
    ));
    
    $_SESSION['success'] = "Profile deleted";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
 <title>0fb3f0ec Ferdaous COGING's Add Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Deleting Profile</h1>
    
    <p>First Name: <?= htmlentities($row['first_name']) ?></p>
    <p>Last Name: <?= htmlentities($row['last_name']) ?></p>
    
    <form method="POST" action="delete.php">
        <input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
        <input type="submit" name="delete" value="Delete">
        <input type="button" value="Cancel" onclick="location.href='index.php';">
    </form>
</div>
</body>

</html>
