<?php

$host = "localhost";
$dbname = "user_login";
$username = "root";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print("Connection failed: " . $e->getMessage());
}



// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $query = "SELECT id FROM users WHERE username = :username AND password = :password";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // Redirect to the profile page
        header("Location: profile.php");
        exit();
    } else {
        echo "Invalid credentials. Please try again.";
    }
}
?>
