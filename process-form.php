<?php
include('dbconn.php');
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate phone number
    // Get the form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Prepare the SQL statement using prepared statements to prevent SQL injection
    $stmt = $dbconn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the prepared statement
    if ($stmt->execute()) {
        $last_id = $dbconn->insert_id; // Get the auto-incremented ID
        echo "<script>alert('Your message has been sent! Thank you.');</script>";
        $_SESSION['success'] = true;
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
        $_SESSION['errors'] = array("Error: " . $stmt->error);
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$dbconn->close();
?>

<script>
    // Redirect to contacts.html after displaying the alert
    window.location.href = "index.html";
</script>