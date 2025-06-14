<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email from the form and sanitize it
    $Email = htmlspecialchars(trim($_POST['Email']));

    // Basic validation for email
    if (empty($Email) || !filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back to contact page with an error message
        header("Location: contact.html?error=Please enter a valid email address.");
        exit();
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'attireyard');

    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        // Prepare the statement
        $stmt = $conn->prepare("INSERT INTO esubscribe (Email) VALUES (?)");
        
        if ($stmt) {
            // Bind parameters: "s" means string
            $stmt->bind_param("s", $Email);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to response page after successful insertion
                header("Location: subscribed.html");
                exit();
            } else {
                // Handle execution error
                echo "Error executing statement: " . $stmt->error;
            }
            
            // Close the statement
            $stmt->close();
        } else {
            // Handle preparation error
            echo "Error preparing statement: " . $conn->error;
        }

        // Close the connection
        $conn->close();
    }
} else {
    header("Location: contact.html");
    exit();
}
?>

