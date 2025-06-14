<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        // Redirect back to contact page with an error message
        header("Location: contact.html?error=Please fill in all required fields.");
        exit();
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'attireyard');

    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        // Prepare the statement
        $stmt = $conn->prepare("INSERT INTO contactus (name, email, phone, message) VALUES (?, ?, ?, ?)");
        
        if ($stmt) {
            // Bind parameters: "ssis" means string, string, integer, string
            $stmt->bind_param("ssis", $name, $email, $phone, $message);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to response page after successful insertion
                header("Location: response.html");
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

