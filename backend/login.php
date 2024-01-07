<?php
include 'config.php';
session_start();
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email;
        header("Location: ../frontend/html/loggedinUser/successLogin.php");
        exit();
    } else {
        echo "Login failed. Please check your credentials.";
        echo "Error: " . $stmt->error;
        exit();
    }

    $stmt->close();
}

?>
