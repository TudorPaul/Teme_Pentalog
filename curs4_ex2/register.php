<?php
$host = "localhost";
$dbname = "user_login";
$username = "root";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $verifyQuery = "SELECT id FROM users WHERE username = :username";
    $verifyStmt = $pdo->prepare($verifyQuery);
    $verifyStmt->bindParam(":username", $username);
    $verifyStmt->execute();
    
    if ($verifyStmt->rowCount() > 0) {
        echo "Username already exists. Please choose a different username.";
    }else{
    
    // Hash the password (for security)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user into the database
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);
    }
    if ($stmt->execute()) {
        // Redirect to the profile page after successful registration
        header("Location: profile.php");
        exit();
    } else {
        echo "Error registering user.";
    }
}
?>

