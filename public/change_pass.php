<?php
// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=lsi_app', 'root', '');

// Query to get all the rows you want to hash
$sql = "SELECT id, password FROM users";
$stmt = $pdo->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $original_value = "pass";

    // Hash the value using bcrypt
    $hashed_value = password_hash($original_value, PASSWORD_BCRYPT);

    // Update the row with the hashed value
    $update_sql = "UPDATE users SET password = :hashed_value WHERE id = :id";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->execute([':hashed_value' => $hashed_value, ':id' => $id]);
}

echo "All rows updated with bcrypt hashed values!";
?>