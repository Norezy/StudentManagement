<?php
    // Ensure no output is sent before session_start()
    ob_start();
    session_start();

    require_once '../Database/Database.php';
    require_once '../models/User.php';

    $db = new Database();
    $conn = $db->getConnection();
    User::setConnection($conn);

    $user = User::find($_POST['user_id']);
    include "../layout/header.php";
    include "../layout/sidebar.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar']) && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $uploadDir = '../images/avatars/';
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Check for errors
    if ($_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = $_FILES['avatar']['name'];
        $fileType = $_FILES['avatar']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // Allowed file types
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            // Generate unique file name
            $newFileName = 'avatar_' . $userId . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Update user's avatar in the database
                $user->avatar = $newFileName;
                $user->save();
                $_SESSION['success'] = 'Avatar updated successfully!';
                
            } else {
                $_SESSION['error'] = 'There was an error uploading the file.';
            }
        } else {
            $_SESSION['error'] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.';
        }
    } else {
        $_SESSION['error'] = 'Error uploading file. Error code: ' . $_FILES['avatar']['error'];
    }
    header('Location: index.php'); // Redirect back to profile page
    ob_end_flush(); // Flush output buffer
}
?>

<?php include "../layout/footer.php"; ?>