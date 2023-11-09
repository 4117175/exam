<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $dbHost = 'localhost'; // XAMPP default database host
    $dbUsername = 'root'; // XAMPP default username
    $dbPassword = ''; // Leave it blank for XAMPP
    $dbName = 'exam'; // Your database name

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password for security (use a more secure hashing method in production)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the "user" table
    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);

    if ($stmt->execute()) {
        // Registration successful, show an alert
        echo '<script>alert("Registration successful! You can now log in.");</script>';
        // Redirect to another page
        header("Location: index.html"); // Replace with the page you want to redirect to
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>