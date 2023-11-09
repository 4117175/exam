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
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve user data from the "users" table
    $sql = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

   if ($user && password_verify($password, $user['password'])) {
    // Authentication successful
    // Store the user's ID in a session variable
    session_start();
    $_SESSION['user_id'] = $user['id'];
    
    // Debug: Output the user ID
    echo "User ID: " . $_SESSION['user_id'];

    // Redirect to a welcome page
    header("location: user.html");
    exit();
} else {
    echo "Invalid email or password";
}


    // Close the database connection
    $stmt->close();
    $conn->close();
}

?>

<script>
  var userIsInvalid = <?php echo $user && password_verify($password, $user['password']) ? 'false' : 'true' ?>;

  if (userIsInvalid) {
    var modal = document.getElementById('invalidModal');
    var closeBtn = document.getElementsByClassName('close')[0];

    modal.style.display = 'block';

    // Close the modal when the close button is clicked
    closeBtn.onclick = function () {
      modal.style.display = 'none';
    }

    // Close the modal when clicking outside the modal
    window.onclick = function (event) {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    }
  }
</script>
