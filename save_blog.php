<?php

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    // Check if the form is submitted
    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $blogTitle = $_POST['blogTitle'];
        $blogContent = $_POST['blogContent'];

        // Handle image upload
        if (isset($_FILES['blogImage'])) {
            $uploadDirectory = "upload/"; // Replace with the directory where you want to save images

            $uploadedFile = $_FILES['blogImage']['tmp_name'];
            $imageFileName = $_FILES['blogImage']['name'];

            $destination = $uploadDirectory . $imageFileName;

            if (move_uploaded_file($uploadedFile, $destination)) {
                // File was uploaded successfully
            } else {
                // Handle upload error
                throw new Exception("Image upload failed.");
            }
        }

        // Insert the blog data into the database
        $sql = "INSERT INTO blog_posts (title, content, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error in the SQL query: " . $conn->error);
        }

        $stmt->bind_param("sss", $blogTitle, $blogContent, $imageFileName);

        if ($stmt->execute()) {
            // Blog post saved successfully
            echo "Blog post saved successfully.";
        } else {
            // Handle database insert error
            throw new Exception("Error in database insertion: " . $stmt->error);
        }

        // Close the database connection
        $stmt->close();
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>