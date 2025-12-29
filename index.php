<?php
session_start();
require_once "pdo.php";

// Fetch all profiles
$stmt = $pdo->query("SELECT * FROM Profile");
$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>FERDAOUS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>John Doe's Profile Database</h1>
    
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<p style="color: green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }
    ?>
    
    <?php if (!isset($_SESSION['name'])): ?>
        <p><a href="login.php">Please log in</a></p>
    <?php else: ?>
        <p><a href="logout.php">Logout</a> | <a href="add.php">Add New Entry</a></p>
    <?php endif; ?>
    
    <h2>Profiles</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Headline</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($profiles) > 0): ?>
                <?php foreach ($profiles as $profile): ?>
                    <tr>
                        <td>
                            <a href="view.php?profile_id=<?= $profile['profile_id'] ?>">
                                <?= htmlentities($profile['first_name'] . ' ' . $profile['last_name']) ?>
                            </a>
                        </td>
                        <td><?= htmlentities($profile['headline']) ?></td>
                        <td>
                            <a href="view.php?profile_id=<?= $profile['profile_id'] ?>">View</a>
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $profile['user_id']): ?>
                                | <a href="edit.php?profile_id=<?= $profile['profile_id'] ?>">Edit</a>
                                | <a href="delete.php?profile_id=<?= $profile['profile_id'] ?>">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3">No profiles found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>

</html>

