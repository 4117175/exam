<?php
// Start or resume the current session
session_start();

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
    $user_id = $_SESSION['user_id']; // Retrieve user ID from the session

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the password is empty (to avoid updating the password if left empty)
    if (!empty($password)) {
        // Hash the password for security (use a more secure hashing method in production)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // If the password is not provided, use the existing password
        // You should fetch the existing hashed password from the database here
        // For example: $existingUser = fetchUserFromDatabase($user_id);
        // $hashedPassword = $existingUser['password'];
    }

    // Update user data in the "users" table
    $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("ssssi", $firstName, $lastName, $email, $hashedPassword, $user_id);

    if ($stmt->execute()) {
        // Profile updated successfully, show a success message
        echo '<script>alert("Profile updated successfully.");</script>';
        header("location: Profile.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
