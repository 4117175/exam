<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database configuration
    $dbHost = 'localhost';
    $dbUsername = 'your_username';
    $dbPassword = 'your_password';
    $dbName = 'your_database_name';

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    $title = $_POST["title"];
    $content = $_POST["content"];

    // Handle image upload
    $image = $_FILES["image"];

    if ($image["error"] === 0) {
        $imagePath = 'uploads/' . basename($image["name"]);

        if (move_uploaded_file($image["tmp_name"], $imagePath)) {
            // Image upload successful
        } else {
            // Image upload failed
        }
    } else {
        // No image uploaded
    }

    // Insert the blog post data into the database
    $sql = "INSERT INTO blog_posts (title, content, image_path) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("sss", $title, $content, $imagePath);

    if ($stmt->execute()) {
        // Blog post creation successful
        header("Location: success.html"); // Redirect to a success page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
