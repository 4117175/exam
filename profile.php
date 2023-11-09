<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animated Dark Mode Button |Dev Mode</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- ICONS CDN FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
    
  <div class="btn">
    <div class="btn__indicator">
      <div class="btn__icon-container">
        <i class="btn__icon fa-solid"></i>
      </div>
    </div>
  </div>
<nav class="navMenu">
      <a href="user.html">Home</a>
      <a href="blog.html">Blog</a>
      <a href="profile.php">Profile</a>
      <a href="#">About</a>
      <a href="index.html" class="logout">Logout</a>
      <div class="dot"></div>
    </nav>
  <script src="js/main.js"></script>
 

<?php
// Establish a database connection (replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$database = "exam";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Fetch user data from the database
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        // Continue with displaying the user's data
    } else {
        die("User not found.");
    }
} else {
    die("User not found.");
}

$conn->close();
?>


<div class="form1">
    <title>Edit Your Profile</title>

<h1>Edit Your Profile</h1>

<form id="editForm" method="post" action="update_user.php" style="margin:top 20vh;">
    <label class="name1" for="firstName">First Name:</label>
    <input class="name1" type="text" id="firstName" name="firstName" required value="<?php echo $user_data['first_name']; ?>"><br><br>

    <label class="name1" for="lastName">Last Name:</label>
    <input class="name1" type="text" id="lastName" name="lastName" required value="<?php echo $user_data['last_name']; ?>"><br><br>

    <label class="name1" for="email">Email:</label>
    <input class="name1" type="email" id="email" name="email" required value="<?php echo $user_data['email']; ?>"><br><br>

    <label class="name1" for ="password">Password:</label>
    <input class="name1" type="password" id="password" name="password" required value="<?php echo $user_data['password']; ?>"><br><br>

    <input type="submit" value="Save Changes">
</form>
</div>

<style>

input.name1[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div.form1 {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  position: absolute;
      left: 40%;
      top: 20%;
}

input.name1[type=email], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input.name1[type=password], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
</style>
</body>
</html>
