<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if a new profile picture was uploaded
    if (isset($_FILES["profilePic"]) && $_FILES["profilePic"]["error"] === 0) {
        $uploadDir = "uploads/";
        $fileName = basename($_FILES["profilePic"]["name"]);
        $targetFilePath = $uploadDir . $fileName;

        // Move uploaded file to the server folder
        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $targetFilePath)) {
            echo json_encode(["status" => "success", "message" => "Profile updated!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to upload image"]);
        }
    }

    // Update user name (You should save this in a database)
    if (isset($_POST["userName"]) && !empty($_POST["userName"])) {
        $newName = htmlspecialchars($_POST["userName"]);
        // Save $newName in the database
        echo json_encode(["status" => "success", "message" => "Name updated!"]);
    }
}
?>
