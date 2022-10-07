<?php
$servername = "localhost";
$username = "root";
$password = "asdf";
$dbname = "loginDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validation
$emailErr = "";
$email = "";
// Request Method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = trimmer($_POST["email"]);
    }
}
// Clear Whitespaces
function trimmer($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// Query
$selectData = "SELECT email FROM MyUsers WHERE email = '$email'";
$result = $conn->query($selectData);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "Hello " . $row["email"] . "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    E-mail: <input type="text" name="email"><br>
    <span class="error">* <?php echo $emailErr; ?></span>
    <input type="submit" value="Login">
</form>